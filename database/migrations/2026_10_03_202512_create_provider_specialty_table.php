<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provider_specialty', function (Blueprint $table) {
            $table->id();

            $table->foreignId('provider_id')
                ->constrained('providers')
                ->cascadeOnDelete();

            $table->foreignId('specialty_id')
                ->constrained('specialties')
                ->cascadeOnDelete();

            $table->timestamps();

            // Prevent duplicate provider-specialty relationships
            $table->unique(['provider_id', 'specialty_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_specialty');
    }
};