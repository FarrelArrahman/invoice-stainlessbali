<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'name' => 'invoice_note',
            'value' => '<strong>#Prices can change at any time, so please confirm before ordering#<br>
            #processing 20-25 working days according to the queue</strong><br><br>
            *As a sign of completion, please pay a down payment of at least Rp. ${down_payment}%<br>
            directly to our location: Jl. Tukad Badung No.104 Renon<br>
            Or By Transfer :<br>
            BCA : 7725344511<br>
            An : Muhammad Ferrizal Zulkarnain',
        ]);
    }
}
