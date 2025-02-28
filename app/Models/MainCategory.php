<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MainCategory extends Model
{
    protected $fillable = ["categoryName", "categoryImg"];

    public function categories()
    {
        return $this->hasMany(Category::class, 'main_category_id'); // 'main_category_id' is the foreign key in Category
    }
}
