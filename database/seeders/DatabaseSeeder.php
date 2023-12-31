<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Technician;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
            SettingSeeder::class,
            CompanySeeder::class,
            TechnicianSeeder::class,
            EmployeeSeeder::class,
            IncomeSeeder::class,
            EmployeeExpenditureSeeder::class,
            TechnicianExpenditureSeeder::class,
            OperationalExpenditureSeeder::class,
            MaterialExpenditureSeeder::class,
        ]);
    }
}
