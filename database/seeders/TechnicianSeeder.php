<?php

namespace Database\Seeders;

use App\Models\Technician;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Technician::factory()->count(10)->create();
    }
}
