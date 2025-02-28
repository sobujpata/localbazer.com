<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=[
        "title",
        "short_des",
        "price",
        "discount",
        "discount_price",
        "stock",
        "star",
        "remark",
        "main_category_id",
        "category_id",
        "brand_id",
        "image",
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id'); // 'Category id' is the foreign key
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function main_category()
    {
        return $this->belongsTo(MainCategory::class);
    }
    public function product_details()
    {
        return $this->belongsTo(ProductDetail::class);
    }
    
}
