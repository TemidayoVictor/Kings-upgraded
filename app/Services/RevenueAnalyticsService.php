<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Sale;
use App\Enums\Status;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RevenueAnalyticsService
{
    /**
     * Get complete revenue dashboard data
     */
    public static function getDashboardData($brandId, $filters = []): array
    {
        $startDate = $filters['start_date'] ?? Carbon::now()->subDays(30);
        $endDate = $filters['end_date'] ?? Carbon::now();

        return [
            'summary' => self::getRevenueSummary($brandId, $startDate, $endDate),
            'daily_breakdown' => self::getDailyRevenue($brandId, $startDate, $endDate),
            'sales_performance' => self::getSalesPerformance($brandId, $startDate, $endDate),
            'top_products' => self::getTopProducts($brandId, $startDate, $endDate),
            'payment_methods' => self::getPaymentMethodDistribution($brandId, $startDate, $endDate),
            'period_comparison' => self::getPeriodComparison($brandId, $startDate, $endDate),
        ];
    }

    /**
     * Get revenue summary metrics
     */
    public static function getRevenueSummary($brandId, $startDate, $endDate): array
    {
        return Order::where('brand_id', $brandId)
            ->where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select([
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(CASE WHEN dropshipper_store_id IS NULL THEN subtotal ELSE 0 END) as gross_revenue'),
                DB::raw('SUM(CASE WHEN dropshipper_store_id IS NOT NULL THEN subtotal ELSE 0 END) as dropshipper_gross_revenue'),
                DB::raw('SUM(CASE WHEN payment_status = "paid" THEN total ELSE 0 END) as paid_revenue'),
                DB::raw('SUM(CASE WHEN payment_status = "pending" THEN total ELSE 0 END) as pending_revenue'),
                DB::raw('AVG(subtotal) as average_order_value'),
                DB::raw('SUM(discount) as total_discounts'),
                DB::raw('SUM(shipping) as total_shipping'),
                DB::raw('SUM(tax) as total_tax'),
                DB::raw('COUNT(DISTINCT DATE(created_at)) as active_days'),
            ])
            ->first()
            ->toArray();
    }

    /**
     * Get daily revenue breakdown
     */
    public static function getDailyRevenue($brandId, $startDate, $endDate): Collection
    {
        return Order::where('brand_id', $brandId)
            ->where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select([
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(subtotal) as revenue'),
                DB::raw('SUM(CASE WHEN payment_status = "paid" THEN subtotal ELSE 0 END) as paid_revenue'),
                DB::raw('COUNT(DISTINCT user_id) as unique_customers'),
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get sales performance (campaigns)
     * Using order_items since sale_id is there
     */
    public static function getSalesPerformance($brandId, $startDate, $endDate): Collection
    {
        return Sale::where('brand_id', $brandId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->map(function ($sale) use ($brandId, $startDate, $endDate) {
                // Get order items for this sale within date range
                $orderItemsQuery = OrderItem::where('sale_id', $sale->id)
                    ->whereHas('order', function ($query) use ($brandId, $startDate, $endDate) {
                        $query->where('brand_id', $brandId)
                            ->where('status', '!=', Status::CANCELLED)
                            ->whereBetween('created_at', [$startDate, $endDate]);
                    });

                $itemsSold = $orderItemsQuery->sum('quantity');
                $revenueGenerated = $orderItemsQuery->sum('subtotal');
                $uniqueOrders = $orderItemsQuery->distinct('order_id')->count('order_id');

                return (object) [
                    'id' => $sale->id,
                    'name' => $sale->name,
                    'discount_type' => $sale->discount_type,
                    'discount_value' => $sale->discount_value,
                    'start_date' => $sale->starts_at,
                    'end_date' => $sale->ends_at,
                    'ongoing' => $sale->ongoing,
                    'items_sold' => $itemsSold,
                    'revenue_generated' => $revenueGenerated,
                    'orders_count' => $uniqueOrders,
                    'total_amount' => $sale->total_amount,
                    'total_orders' => $sale->total_orders,
                ];
            })
            ->filter(function ($sale) {
                // Only show sales with activity
                return $sale->items_sold > 0 || $sale->orders_count > 0;
            })
            ->values();
    }

    /**
     * Get top performing products
     */
    public static function getTopProducts($brandId, $startDate, $endDate, $limit = 10): Collection
    {
        return OrderItem::with('product')->whereHas('order', function ($query) use ($brandId, $startDate, $endDate) {
            $query->where('brand_id', $brandId)
                ->where('status', '!=', 'cancelled')
                ->whereBetween('created_at', [$startDate, $endDate]);
        })
            ->select([
                'product_id',
                'product_name',
                'sku',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('COUNT(DISTINCT order_id) as order_count'),
                DB::raw('SUM(total) as total_revenue'),
                DB::raw('AVG(unit_price) as average_price'),
            ])
            ->groupBy('product_id', 'product_name', 'sku')
            ->orderByDesc('total_revenue')
            ->limit($limit)
            ->get();
    }

    /**
     * Get payment method distribution
     */
    public static function getPaymentMethodDistribution($brandId, $startDate, $endDate): Collection
    {
        $totalRevenue = Order::where('brand_id', $brandId)
            ->where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('subtotal');

        return Order::where('brand_id', $brandId)
            ->where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select([
                'payment_method',
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(subtotal) as total_amount'),
            ])
            ->groupBy('payment_method')
            ->get()
            ->map(function ($item) use ($totalRevenue) {
                $item->percentage = $totalRevenue > 0
                    ? ($item->total_amount / $totalRevenue) * 100
                    : 0;

                return $item;
            });
    }

    /**
     * Compare with previous period
     */
    public static function getPeriodComparison($brandId, $startDate, $endDate): array
    {
        $currentPeriod = self::getRevenueSummary($brandId, $startDate, $endDate);

        $daysDiff = Carbon::parse($startDate)->diffInDays($endDate);
        $previousStart = Carbon::parse($startDate)->subDays($daysDiff);
        $previousEnd = Carbon::parse($endDate)->subDays($daysDiff);

        $previousPeriod = self::getRevenueSummary($brandId, $previousStart, $previousEnd);

        return [
            'current' => $currentPeriod,
            'previous' => $previousPeriod,
            'growth' => [
                'revenue' => self::calculateGrowth($currentPeriod['gross_revenue'], $previousPeriod['gross_revenue']),
                'orders' => self::calculateGrowth($currentPeriod['total_orders'], $previousPeriod['total_orders']),
                'aov' => self::calculateGrowth($currentPeriod['average_order_value'], $previousPeriod['average_order_value']),
            ],
        ];
    }

    /**
     * Get real-time revenue metrics
     */
    public static function getRealTimeMetrics($brandId): array
    {
        $today = Carbon::today();
        $lastHour = Carbon::now()->subHour();

        return [
            'today_revenue' => Order::where('brand_id', $brandId)
                ->whereDate('created_at', $today)
                ->where('status', '!=', Status::CANCELLED)
                ->sum('subtotal'),

            'today_orders' => Order::where('brand_id', $brandId)
                ->whereDate('created_at', $today)
                ->where('status', '!=', Status::CANCELLED)
                ->count(),

            'last_hour_revenue' => Order::where('brand_id', $brandId)
                ->where('created_at', '>=', $lastHour)
                ->where('status', '!=', Status::CANCELLED)
                ->sum('subtotal'),

            'pending_payments' => Order::where('brand_id', $brandId)
                ->where('payment_status', Status::PENDING)
                ->sum('total'),

            'undelivered_orders' => Order::where('brand_id', $brandId)
                ->where('status', Status::PENDING)
                ->where(function ($query) {
                    $query->whereNull('dropshipper_store_id')
                        ->orWhere(function ($q) {
                            $q->whereNotNull('dropshipper_store_id')
                                ->where('dropshipper_status', Status::APPROVED);
                        });
                })
                ->count(),

            'ongoing_sales_revenue' => OrderItem::whereHas('sale', function ($query) use ($brandId) {
                $query->where('brand_id', $brandId)
                    ->where('ongoing', true);
            })
                ->whereHas('order', function ($query) use ($brandId) {
                    $query->where('brand_id', $brandId)
                        ->where('status', '!=', Status::CANCELLED);
                })
                ->sum('subtotal'),
        ];
    }

    /**
     * Get revenue by customer type (guest vs registered)
     */
    public static function getCustomerRevenueSegments($brandId, $startDate, $endDate): array
    {
        $orders = Order::where('brand_id', $brandId)
            ->where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $guestOrders = $orders->whereNull('user_id');
        $registeredOrders = $orders->whereNotNull('user_id');

        return [
            'guest' => [
                'order_count' => $guestOrders->count(),
                'total_revenue' => $guestOrders->sum('subtotal'),
                'average_order_value' => $guestOrders->avg('subtotal') ?? 0,
            ],
            'registered' => [
                'order_count' => $registeredOrders->count(),
                'total_revenue' => $registeredOrders->sum('subtotal'),
                'average_order_value' => $registeredOrders->avg('subtotal') ?? 0,
            ],
        ];
    }

    /**
     * Calculate growth percentage
     */
    private static function calculateGrowth($current, $previous): int
    {
        if ($previous == 0 || $previous == null) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100, 2);
    }
}
