<?php

namespace App\Models;

use App\Enums\TransactionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialExpenditure extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'shop_name',
        'shop_address',
        'shop_telephone_number',
        'total_price',
        'shop_name',
        'note',
        'date',
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
        'date' => 'datetime',
        'status' => TransactionEnum::class
    ];

    // Attribute
    public function getFormattedTotalPriceAttribute()
    {
        return "Rp. " . number_format($this->total_price, 0, '', '.');
    }

    public function items()
    {
        return $this->hasMany(MaterialExpenditureDetail::class, 'material_expenditure_id', 'id');
    }

    public function badge(): string
    {
        return "<div class=\"badge bg-danger\">Bahan</div>";
    }

    public function getTypeAttribute(): string
    {
        return "Bahan";
    }

    public function edit_route()
    {
        return route('material_expenditures.edit', $this->id);
    }
    
    public function delete_route()
    {
        return route('material_expenditures.destroy', $this->id);
    }
}
