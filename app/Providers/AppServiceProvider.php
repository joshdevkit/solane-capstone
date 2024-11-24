<?php

namespace App\Providers;

use App\Models\Products;
use App\Models\User;
use App\Notifications\LowStockNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema; // Import Schema
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('products') && Schema::hasTable('users')) {
            $this->checkStockLevels();
        }
    }

    protected function checkStockLevels()
    {
        $lastNotificationTime = Cache::get('last_low_stock_notification_time');

        if (!$lastNotificationTime || now()->diffInHours($lastNotificationTime) >= 24) {
            $lowStockProducts = Products::where('quantity', '<', 20)->get();

            if ($lowStockProducts->isNotEmpty()) {
                $users = User::whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'Sales');
                })->get();

                foreach ($lowStockProducts as $product) {
                    foreach ($users as $user) {
                        $user->notify(new LowStockNotification($product));
                    }
                }

                Cache::put('last_low_stock_notification_time', now());
            }
        }
    }
}
