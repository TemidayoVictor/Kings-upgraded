<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (! $user) {
            return redirect()->route('login');
        }

        return redirect()->route($user->dashboardRoute());
    }
}
