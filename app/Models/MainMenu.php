<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainMenu extends Model
{
    protected $fillable = ["name"];

    public function sub_menus()
    {
        return $this->hasMany(SubMenu::class, 'main_menu_id', 'id');
    }

}
