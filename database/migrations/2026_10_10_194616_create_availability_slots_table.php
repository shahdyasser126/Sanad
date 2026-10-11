<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('availability_slots', function (Blueprint $table) {
            $table->id();

            $table->foreignId('provider_id')
                ->constrained('providers')
                ->cascadeOnDelete();

            $table->dateTime('starts_at');
            $table->dateTime('ends_at');

            $table->boolean('is_available')->default(true);

            $table->timestamps();

            $table->index(['provider_id', 'starts_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('availability_slots');
    }
};