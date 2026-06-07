<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Brand;
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

        return view('home', [
            'brands' => $brands,
        ]);
    }

    public function brands(): View
    {
        return view('brands');
    }

    public function sales(): View
    {
        return view('sales');
    }

    public function features(): View
    {
        return view('features');
    }
}
