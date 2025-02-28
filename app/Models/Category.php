<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    protected $fillable = ["categoryName", "categoryImg", "main_category_id"];

    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'main_category_id'); // 'main_category_id' is the foreign key
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
