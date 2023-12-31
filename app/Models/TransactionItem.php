<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_breakdown_id',
        'item_id',
        'name',
        'image',
        'brand',
        'model',
        'width',
        'depth',
        'height',
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

    // Relationship
    public function breakdown()
    {
        return $this->belongsTo(TransactionBreakdown::class, 'transaction_breakdown_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

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
