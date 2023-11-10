<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Enums\TransactionEnum;
use App\Models\Company;
use App\Models\MaterialExpenditure;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialExpenditureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shops = Company::where('status', StatusEnum::Active)->get()->toArray();

        for($i = 0; $i <= fake()->numberBetween(1000, 10000); $i++) {
            $shop = fake()->randomElement($shops);
            $materialExpenditureData = [
                'shop_name' => $shop['name'],
                'shop_telephone_number' => $shop['telephone_number'],
                'shop_address' => $shop['address'],
                'status' => TransactionEnum::Paid,
                'total_price' => 0,
                'date' => Carbon::today()->subDays(rand(0, 1460)),
            ];

            $materialExpenditure = MaterialExpenditure::create($materialExpenditureData);

            $materialExpenditureDetailData = [];
            $totalPrice = 0;

            for($j = 0; $j <= fake()->numberBetween(1, 10); $j++) {
                $price = fake()->numberBetween(1, 10) * 5000;
                $qty = fake()->numberBetween(1, 100);
                
                $materialExpenditureDetailData[] = [
                    'material_expenditure_id' => $materialExpenditure->id,
                    'item_name' => fake()->sentence(3),
                    'price' => $price,
                    'qty' => $qty,
                    'status' => '',
                ];

                $totalPrice += $price * $qty;
            }

            $materialExpenditure->update([
                'total_price' => $totalPrice
            ]);

            $materialExpenditure->items()->createMany($materialExpenditureDetailData);
        }
    }
}
