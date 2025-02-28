<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $fillable=['product_id','img1','img2','img3','img4', 'color', 'des', 'size'];
}
