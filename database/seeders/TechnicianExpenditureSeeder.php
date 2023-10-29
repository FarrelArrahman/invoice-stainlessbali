<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Enums\TransactionEnum;
use App\Models\Technician;
use App\Models\TechnicianExpenditure;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnicianExpenditureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technicians = Technician::where('status', StatusEnum::Active)->get()->toArray();

        for($i = 0; $i <= fake()->numberBetween(100, 1000); $i++) {
            $serviceFee = fake()->numberBetween(1, 20) * 50000;

            $technician = fake()->randomElement($technicians);
            $technicianExpenditureData = [
                'technician_id' => $technician['id'],
                'note' => "",
                'date' => Carbon::today()->subDays(rand(0, 365)),
                'status' => TransactionEnum::Paid,
                'service_fee' => $serviceFee,
                'total_price' => 0,
            ];

            $technicianExpenditure = TechnicianExpenditure::create($technicianExpenditureData);

            $technicianExpenditureDetailData = [];
            $totalPrice = 0;

            for($j = 0; $j <= fake()->numberBetween(1, 10); $j++) {
                $price = fake()->numberBetween(1, 10) * 50000;
                $qty = fake()->numberBetween(1, 100);
                
                $technicianExpenditureDetailData[] = [
                    'technician_expenditure_id' => $technicianExpenditure->id,
                    'item_name' => fake()->sentence(3),
                    'price' => $price,
                    'qty' => $qty,
                    'status' => '',
                ];

                $totalPrice += $price * $qty;
            }

            $technicianExpenditure->update([
                'total_price' => $totalPrice
            ]);

            $technicianExpenditure->items()->createMany($technicianExpenditureDetailData);
        }
    }
}
