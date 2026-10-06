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
        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->id();

            // One doctor profile belongs to one provider.
            $table->foreignId('provider_id')
                ->unique()
                ->constrained('providers')
                ->cascadeOnDelete();

            // Doctor-specific information
            $table->string('qualification')->nullable();
            $table->string('license_number')->nullable();
            $table->text('affiliations')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_profiles');
    }
};