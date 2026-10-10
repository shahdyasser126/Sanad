<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SpecialtySeeder::class,
            ProviderSeeder::class,
            ServiceSeeder::class,
            AvailabilitySlotSeeder::class,
        ]);
    }
}