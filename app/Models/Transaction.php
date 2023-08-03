<?php

namespace App\Models;

use App\Enums\TransactionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'customer_id',
        'handled_by',
        'date',
        'total_price',
        'discount_nominal',
        'discount_percentage',
        'payment_terms',
        'status',
        'note',
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
        'status' => TransactionEnum::class
    ];

    protected $dates = [
        'date'
    ];

    // Attribute
    public function getFormattedTotalPriceAttribute()
    {
        return "Rp. " . number_format($this->total_price, 0, '', '.');
    }

    // Relationship
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function handledBy()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function breakdowns()
    {
        return $this->hasMany(TransactionBreakdown::class, 'transaction_id');
    }

}
