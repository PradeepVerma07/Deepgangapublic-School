<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{
    public $timestamps = false;
    protected $table = 'admin_role_menus';

    protected $fillable = [
        'role_id',
        'menu_id',
        'add_update',
        'trash',
        'view',
    ];

    protected $casts = [
        'add_update' => 'boolean',
        'trash' => 'boolean',
        'view' => 'boolean',
    ];



    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
