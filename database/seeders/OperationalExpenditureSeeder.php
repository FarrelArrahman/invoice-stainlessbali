<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Enums\TransactionEnum;
use App\Models\Company;
use App\Models\OperationalExpenditure;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperationalExpenditureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shops = Company::where('status', StatusEnum::Active)->get()->toArray();

        for($i = 0; $i <= fake()->numberBetween(100, 1000); $i++) {
            $shop = fake()->randomElement($shops);
            $operationalExpenditureData = [
                'shop_name' => $shop['name'],
                'shop_telephone_number' => $shop['telephone_number'],
                'shop_address' => $shop['address'],
                'status' => TransactionEnum::Paid,
                'total_price' => 0,
                'date' => Carbon::today()->subDays(rand(0, 365)),
            ];

            $operationalExpenditure = OperationalExpenditure::create($operationalExpenditureData);

            $operationalExpenditureDetailData = [];
            $totalPrice = 0;

            for($j = 0; $j <= fake()->numberBetween(1, 10); $j++) {
                $price = fake()->numberBetween(1, 10) * 50000;
                $qty = fake()->numberBetween(1, 100);
                
                $operationalExpenditureDetailData[] = [
                    'operational_expenditure_id' => $operationalExpenditure->id,
                    'item_name' => fake()->sentence(3),
                    'price' => $price,
                    'qty' => $qty,
                    'status' => '',
                ];

                $totalPrice += $price * $qty;
            }

            $operationalExpenditure->update([
                'total_price' => $totalPrice
            ]);

            $operationalExpenditure->items()->createMany($operationalExpenditureDetailData);
        }
    }
}
