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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('number', 50);
            $table->string('vin', 50)->nullable();
            $table->boolean('is_clean');
            $table->boolean('is_available_for_rent');
            $table->boolean('is_door_opened');
            $table->boolean('is_in_parking');
            $table->integer('rating');
            $table->integer('fuel_in_tank');
            $table->string('location', 255);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
