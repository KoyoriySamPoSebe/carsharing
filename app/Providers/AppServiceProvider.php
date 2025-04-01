<?php

declare(strict_types=1);

namespace App\Providers;

use App\Livewire\RentTable;
use App\Models\Rent;
use App\Models\User;
use App\Models\Vehicle;
use App\Repositories\RentRepository;
use App\Repositories\VehicleRepository;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(VehicleRepository::class)
            ->needs(Builder::class)
            ->give(function () {
                return Vehicle::query();
            });

        $this->app->when(RentRepository::class)
            ->needs(Builder::class)
            ->give(function () {
                return Rent::query();
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function (User $user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });
        Livewire::component('rent-table', RentTable::class);

        Connection::macro('point', function ($latitude, $longitude) {
            return DB::raw("ST_MakePoint($longitude, $latitude)");
        });
    }
}
