<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, HasFactory;
    
    public $timestamps = false;
    
    public $dates = [
        'date_and_time'
    ];
    
    public $casts = [
        'date_and_time' => 'datetime',
    ];
    
    public $fillable = [
        'name', 'description', 'date_and_time',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getDateAndTimeAttribute($data)
    {
        return Carbon::parse($data)->format('Y-m-d');
    }
    
}
