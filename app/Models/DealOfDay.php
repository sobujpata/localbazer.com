<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealOfDay extends Model
{
   protected $fillable=["product_id", "sold", "image_url", "count_down"];

   public function products()
    {
        return $this->belongsTo(Product::class, 'product_id'); // 'product_id' is the foreign key
    }
}
