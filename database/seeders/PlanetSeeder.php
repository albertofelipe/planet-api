<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Planet;


class PlanetSeeder extends Seeder
{
    public function run(): void
    {
        Planet::factory()
            ->count(20)
            ->create();
    }
}
