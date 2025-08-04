<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\ProvinsiSeeder;
use Database\Seeders\KotaSeeder;
use Database\Seeders\StatusSeeder;
use Database\Seeders\InstitusiSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProvinsiSeeder::class,
            KotaSeeder::class,
            StatusSeeder::class,
            InstitusiSeeder::class,
            EdukasiSeeder::class,
        ]);
    }
}