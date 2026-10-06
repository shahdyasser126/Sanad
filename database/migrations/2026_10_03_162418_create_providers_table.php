<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up(): void
{
    Schema::create('providers', function (Blueprint $table) {
        $table->id();

        // Basic provider information
        $table->enum('type', ['doctor', 'clinic']);
        $table->string('name');
        $table->text('bio')->nullable();

        // Contact information
        $table->string('phone', 20)->nullable();
        $table->string('email')->nullable();
        $table->string('website')->nullable();

        // Location
        $table->string('address_line')->nullable();
        $table->string('city')->nullable();
        $table->string('region')->nullable();
        $table->decimal('latitude', 10, 7)->nullable();
        $table->decimal('longitude', 10, 7)->nullable();

        // Fees
        $table->decimal('fee_min', 10, 2)->nullable();
        $table->decimal('fee_max', 10, 2)->nullable();

        // Rating
        $table->decimal('rating_average', 3, 2)->default(0);
        $table->unsignedInteger('rating_count')->default(0);

        // Verification
        $table->enum('verification_status', [
            'pending',
            'verified',
            'expired',
            'suspended',
            'revoked',
        ])->default('pending');

        $table->timestamp('verified_at')->nullable();

        $table->timestamps();

        // Indexes for discovery/filtering
        $table->index('type');
        $table->index('verification_status');
        $table->index('city');
        $table->index('region');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
