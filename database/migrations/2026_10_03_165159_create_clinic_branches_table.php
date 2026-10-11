<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinic_branches', function (Blueprint $table) {
            $table->id();

            // Every branch belongs to one clinic profile
            $table->foreignId('clinic_profile_id')
                ->constrained('clinic_profiles')
                ->cascadeOnDelete();

            // Branch information
            $table->string('name');

            // Branch location
            $table->string('address_line')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();

            // Map coordinates
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Branch contact
            $table->string('phone', 20)->nullable();

            $table->timestamps();

            // Useful for location filtering
            $table->index('city');
            $table->index('region');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinic_branches');
    }
};