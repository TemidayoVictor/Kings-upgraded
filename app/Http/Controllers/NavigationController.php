<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\View\View;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function home(): View
    {
        $brands = Brand::where('status', Status::COMPLETED)
            ->where('image', '!=', null)
            ->inRandomOrder()->limit(4)
            ->with('products', 'ratings')
            ->get();

        $categories = Category::whereIn(
            'id',
            Brand::where('status', Status::COMPLETED)
                ->whereNotNull('category')
                ->distinct()
                ->pluck('category')
        )
            ->inRandomOrder()
            ->limit(7)
            ->get();

        $featuredProducts = Product::where('is_featured', true)
            ->inRandomOrder()->limit(4)
            ->get();

        return view('home', [
            'brands' => $brands,
            'categories' => $categories,
            'featuredProducts' => $featuredProducts,
            'featuresList' => $this->featuresList(),
        ]);
    }

    public function brands(): View
    {
        $categories = Category::with('subcategories')->orderBy('name')->get();

        $brands = Brand::latest()->get();

        return view('brands', [
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }

    public function sales(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $sales = Sale::query()
            ->with([
                'brand.subcategoryModel',
                'products.images',
                'tags',
            ])
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('ongoing', true)
                    ->orWhere('ends_at', '>', now());
            })
            ->when($search !== '', function ($query) use ($search) {
                $normalizedSearch = mb_strtolower($search);

                $query->where(function ($q) use ($search, $normalizedSearch) {

                    // Search sale name and description
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%")

                        // Search brand name
                        ->orWhereHas('brand', function ($brandQuery) use ($search) {
                            $brandQuery->where('brand_name', 'LIKE', "%{$search}%");
                        })

                        // Search product names
                        ->orWhereHas('products', function ($productQuery) use ($search) {
                            $productQuery->where('name', 'LIKE', "%{$search}%");
                        })

                        // Search sale tags
                        ->orWhereHas('tags', function ($tagQuery) use ($normalizedSearch) {
                            $tagQuery->where(
                                'normalized_name',
                                'LIKE',
                                "%{$normalizedSearch}%"
                            );
                        });
                });
            })
            ->orderByDesc('ongoing')
            ->orderByRaw('CASE WHEN ongoing = 0 THEN ends_at END ASC')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('sales', [
            'sales' => $sales,
            'search' => $search,
        ]);
    }

    protected function featuresList(): array
    {
        return [
            [
                'icon' => 'shopping-bag',
                'title' => 'Online Store',
                'desc' => 'Create a beautiful online store and start selling in minutes.',
            ],
            [
                'icon' => 'share',
                'title' => 'Dropshipping',
                'desc' => 'Expand your reach and increase sales through trusted dropshippers.',
            ],
            [
                'icon' => 'inbox',
                'title' => 'Customer Reviews',
                'desc' => 'Collect and display reviews to build trust with new customers.',
            ],
            [
                'icon' => 'tag',
                'title' => 'Promotions',
                'desc' => 'Run discounts, coupons, and special offers to increase sales.',
            ],
            [
                'icon' => 'chart-pie',
                'title' => 'Analytics',
                'desc' => 'Track sales, orders, and customer activity from one dashboard.',
            ],
            [
                'icon' => 'users',
                'title' => 'Customer Management',
                'desc' => 'Manage customers, orders, and communication with ease.',
            ],
        ];
    }

    public function features(): View
    {
        return view('features');
    }
}
