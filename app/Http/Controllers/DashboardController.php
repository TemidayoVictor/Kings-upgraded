<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $user = auth()->user();
        if(!$user) {
            return redirect()->route('login');
        }
        $role = $user->role;
        return redirect()->route("$role-dashboard");
    }
}
