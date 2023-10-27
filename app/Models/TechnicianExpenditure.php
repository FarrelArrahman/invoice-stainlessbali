<?php

namespace App\Models;

use App\Enums\TransactionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicianExpenditure extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'technician_id',
        'note',
        'date',
        'status',
        'service_fee',
        'total_price'
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

    public function technician()
    {
        return $this->hasOne(Technician::class, 'id', 'technician_id');
    }

    // Attribute
    public function getFormattedTotalPriceAttribute()
    {
        return "Rp. " . number_format($this->total_price, 0, '', '.');
    }

    public function items()
    {
        return $this->hasMany(TechnicianExpenditureDetail::class, 'technician_expenditure_id', 'id');
    }

    public function badge(): string
    {
        return "<div class=\"badge bg-success\">Teknisi</div>";
    }

    public function edit()
    {
        return route('technician_expenditures.edit', $this->id);
    }
    
    public function delete()
    {
        return route('technician_expenditures.destroy', $this->id);
    }
}
