<?php

namespace App\Models;

use App\Enums\TransactionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_name',
        'customer_name',
        'company_telephone_number',
        'customer_phone_number',
        'address',
        'status',
        'total_price',
        'handled_by',
        'date',
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
        'status' => TransactionEnum::class,
        'date' => 'datetime'
    ];

    // Attribute
    public function getFormattedTotalPriceAttribute()
    {
        return "Rp. " . number_format($this->total_price, 0, '', '.');
    }

    public function items()
    {
        return $this->hasMany(IncomeDetail::class, 'income_id', 'id');
    }
}
