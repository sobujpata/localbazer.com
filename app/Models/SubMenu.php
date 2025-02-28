<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    protected $fillable = ["name", "main_menu_id", "url"];

    public function main_menu()
    {
        return $this->belongsTo(MainMenu::class, 'main_menu_id')->withDefault();
    }
}


