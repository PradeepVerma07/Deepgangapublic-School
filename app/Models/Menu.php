<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'admin_menus';

    protected $fillable = [
        'title',
        'url',
        'icon',
        'parent',
        'description',
        'seq',
        'active',
    ];

    public function parentMenu()
    {
        return $this->belongsTo(Menu::class, 'parent');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent');
    }
}
