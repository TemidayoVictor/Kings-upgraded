<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class NavigationController extends Controller
{
    public function home(): View
    {
        $brands = Brand::where('status', Status::COMPLETED)
            ->where('image', '!=', null)
            ->inRandomOrder()->limit(4)
            ->with('products', 'ratings')
            ->get();

        $categories = Category::inRandomOrder()->limit(7)->get();

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

    public function sales(): View
    {
        return view('sales');
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
                'desc' => 'Add products from trusted suppliers and fulfill orders automatically.',
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
