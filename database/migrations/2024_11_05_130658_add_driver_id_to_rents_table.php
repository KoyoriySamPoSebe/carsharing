<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rents', function (Blueprint $table) {
            $table->foreignId('driver_id')->constrained('drivers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rents', function (Blueprint $table) {
            $table->dropForeign(['driver_id']);
        });
    }
};
