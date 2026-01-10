<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;
use App\Models\Inventory;
use App\Models\User;
use App\Notifications\LowStockAlert;

Schedule::call(function () {
    $lowStockItems = Inventory::with('medication')
        ->whereColumn('quantity', '<=', 'minimum_stock_level')
        ->get();

    if ($lowStockItems->isNotEmpty()) {
        $pharmacists = User::where('role', 'Pharmacist')->get();
        
        foreach ($lowStockItems as $item) {
             foreach ($pharmacists as $user) {
                // Ideally check if already notified today using cache
                $user->notify(new LowStockAlert($item));
            }
        }
    }
})->dailyAt('08:00');
