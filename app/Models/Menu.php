<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'icon', 'link', 'position', 'parent', 'access_to'];
    use HasFactory;
    public function child()
    {
        return $this->hasMany(Menu::class, 'parent', 'id');
    }
}
