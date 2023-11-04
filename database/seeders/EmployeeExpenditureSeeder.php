<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Enums\TransactionEnum;
use App\Models\Employee;
use App\Models\EmployeeExpenditure;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeExpenditureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeExpenditureData = [];
        $employees = Employee::where('status', StatusEnum::Active)->get()->toArray();

        foreach($employees as $employee) {
            $salaryPerDay = fake()->numberBetween(5, 15) * 10000;
            for($i = 1; $i <= 10; $i++) {
                $workingDays = fake()->numberBetween(20, 26);

                $employeeExpenditureData[] = [
                    'employee_id' => $employee['id'],
                    'date' => Carbon::createFromDate(2023, $i)->lastOfMonth(),
                    'month' => $i,
                    'year' => 2023,
                    'working_day' => $workingDays,
                    'salary_per_day' => $salaryPerDay,
                    'status' => TransactionEnum::Paid,
                ];
            }
        }

        EmployeeExpenditure::insert($employeeExpenditureData);    
    }
}
