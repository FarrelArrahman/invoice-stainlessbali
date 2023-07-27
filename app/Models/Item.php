<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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
        'status' => StatusEnum::class
    ];

    public function getDimensionAttribute()
    {
        return "{$this->width} x {$this->depth} x {$this->height}";
    }

    public function getFormattedPriceAttribute()
    {
        return "Rp. " . number_format($this->price, 0, '', '.');
    }

    public function getImageRealPathAttribute()
    {
        return Storage::url($this->image);
    }
}
