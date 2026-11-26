<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return view('dashboard', [
            'products'    => $user->products()->with('category')->latest()->paginate(10),
            'activeCount' => $user->products()->available()->count(),
            'soldCount'   => $user->products()->sold()->count(),
            'revenue'     => (int) $user->products()->sold()->sum('sold_price'),
        ]);
    }
}