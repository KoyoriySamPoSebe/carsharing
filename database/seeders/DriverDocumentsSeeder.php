<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\DriverDocuments;
use Illuminate\Database\Seeder;

class DriverDocumentsSeeder extends Seeder
{
    public function run(): void
    {
        DriverDocuments::factory()
            ->count(10)
            ->create();
    }
}
