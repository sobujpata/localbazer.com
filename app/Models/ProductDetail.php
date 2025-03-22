<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'img1',
        'img2',
        'img3',
        'img4',
        'color',
        'des',
        'size',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // Correct relationship
    }
}
