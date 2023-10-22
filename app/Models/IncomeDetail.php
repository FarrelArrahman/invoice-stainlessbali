<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'income_id',
        'name',
        'price',
        'qty',
        'status',
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
        // 
    ];

    // Attribute
    public function getFormattedPriceAttribute()
    {
        return "Rp. " . number_format($this->price, 0, '', '.');
    }

    public function getTotalPriceAttribute()
    {
        return $this->price * $this->qty;
    }
    
    public function getFormattedTotalPriceAttribute()
    {
        return "Rp. " . number_format($this->total_price, 0, '', '.');
    }
}
