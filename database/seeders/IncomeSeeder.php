<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Enums\TransactionEnum;
use App\Models\Customer;
use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::with('company')->where('status', StatusEnum::Active)->get()->toArray();

        for($i = 0; $i <= fake()->numberBetween(1000, 10000); $i++) {
            $customer = fake()->randomElement($customers);
            $incomeData = [
                'company_name' => $customer['company']['name'],
                'customer_name' => $customer['name'],
                'company_telephone_number' => $customer['company']['telephone_number'],
                'customer_phone_number' => $customer['phone_number'],
                'address' => $customer['company']['address'],
                'status' => TransactionEnum::Paid,
                'total_price' => 0,
                'handled_by' => NULL,
                'date' => Carbon::today()->subDays(rand(0, 1460)),
            ];

            $income = Income::create($incomeData);

            $incomeDetailData = [];
            $totalPrice = 0;

            for($j = 0; $j <= fake()->numberBetween(1, 10); $j++) {
                $price = fake()->numberBetween(1, 10) * 50000;
                $qty = fake()->numberBetween(1, 100);
                
                $incomeDetailData[] = [
                    'income_id' => $income->id,
                    'name' => fake()->sentence(3),
                    'price' => $price,
                    'qty' => $qty,
                    'status' => '',
                ];

                $totalPrice += $price * $qty;
            }

            $income->update([
                'total_price' => $totalPrice
            ]);

            $income->items()->createMany($incomeDetailData);
        }
    }
}
