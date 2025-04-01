<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\DocumentType;
use App\Enums\DriverStatus;
use App\Models\Driver;
use App\Models\DriverDocuments;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        foreach (DriverStatus::cases() as $status) {
            $drivers = Driver::factory()
                ->count(3)
                ->create([
                    'status' => $status,
                ]);

            foreach ($drivers as $driver) {
                foreach (DocumentType::cases() as $type) {
                    DriverDocuments::factory()->create([
                        'driver_id' => $driver->id,
                        'type'      => $type,
                    ]);
                }
            }
        }

        $testDriver = Driver::factory()->create([
            'email'             => 'test.driver@example.com',
            'phone'             => '+3814567890',
            'status'            => DriverStatus::APPROVE,
            'is_phone_verified' => true,
            'is_email_verified' => true,
            'approved_at'       => now(),
        ]);

        foreach (DocumentType::cases() as $type) {
            DriverDocuments::factory()->create([
                'driver_id' => $testDriver->id,
                'type'      => $type,
            ]);
        }
    }
}
