<?php

namespace App\Models;

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
        'user_id',
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
        // 
    ];

    // Relationship
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
