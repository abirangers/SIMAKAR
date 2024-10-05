<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $menuCount = \App\Models\Menu::count();
        $totalRevenue = \App\Models\Order::sum('total');
        $orderCount = \App\Models\Order::count();
        $cashierCount = \App\Models\User::where('role', 'kasir')->count();

        return Inertia::render('Dashboard', [
            'menuCount' => $menuCount,
            'totalRevenue' => $totalRevenue,
            'orderCount' => $orderCount,
            'cashierCount' => $cashierCount,
        ]);
    }
}
