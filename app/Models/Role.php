<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'admin_roles';

    protected $fillable = [
        'title',
        'description',
        'active',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'admin_role_menus', 'role_id', 'menu_id')
                    ->withPivot('add_update', 'trash', 'view');
    }
}
