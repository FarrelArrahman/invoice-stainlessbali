<?php

namespace App\Models;

use App\Enums\TransactionEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeExpenditure extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'date',
        'month',
        'year',
        'working_day',
        'salary_per_day',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime',
        'status' => TransactionEnum::class
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }

    // Attribute
    public function getTotalSalaryAttribute()
    {
        return $this->salary_per_day * $this->working_day;
    }

    public function getFormattedTotalPriceAttribute()
    {
        return "Rp. " . number_format($this->total_salary, 0, '', '.');
    }

    public function getSalaryMonthAndYearAttribute()
    {
        return Carbon::create()->day(1)->month($this->month)->year($this->year)->format('F Y');
    }
    
    public function badge(): string
    {
        return "<div class=\"badge bg-info\">Karyawan</div>";
    }

    public function edit_route()
    {
        return route('employee_expenditures.edit', $this->id);
    }
    
    public function delete_route()
    {
        return route('employee_expenditures.destroy', $this->id);
    }
}
