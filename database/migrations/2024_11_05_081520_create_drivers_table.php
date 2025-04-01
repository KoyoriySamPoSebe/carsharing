<?php

declare(strict_types=1);

use App\Enums\DriverStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default(DriverStatus::NEW->value);
            $table->timestamps();
            $table->timestamp('approved_at')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->magellanGeography('location', 4326)->nullable();
            $table->string('password');
            $table->boolean('is_blocked')->default(false);
            $table->boolean('is_phone_verified')->default(false);
            $table->boolean('is_email_verified')->default(false);
            $table->foreignId('last_rent_id')->nullable()->constrained('rents');
            $table->foreignId('active_rent_id')->nullable()->constrained('rents');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
