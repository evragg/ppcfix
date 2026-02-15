<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $dbConnectionStatus = 'Connected';
            $dbName = \Illuminate\Support\Facades\DB::connection()->getDatabaseName();
        } catch (\Exception $e) {
            $dbConnectionStatus = 'Not Connected: ' . $e->getMessage();
            $dbName = 'N/A';
        }

        try {
            $productCount = \App\Models\Product::count();
            $activeSchedulesCount = \App\Models\ProductionSchedule::where('status', '!=', 'completed')->count();
            $pendingOrdersCount = \App\Models\ProductionOrder::where('status', 'pending')->count();
            $stakeholderCount = \App\Models\Stakeholder::count();
        } catch (\Exception $e) {
            // Fallback if DB is down/tables missing
            $productCount = 0;
            $activeSchedulesCount = 0;
            $pendingOrdersCount = 0;
            $stakeholderCount = 0;
        }

        return view('dashboard', compact(
            'dbConnectionStatus',
            'dbName',
            'productCount',
            'activeSchedulesCount',
            'pendingOrdersCount',
            'stakeholderCount'
        ));
    }
}
