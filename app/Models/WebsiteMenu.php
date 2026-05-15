<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteMenu extends Model
{
    use HasFactory;

    protected $table = 'website_menus';

    protected $fillable = [
        'school_id',
        'title',
        'slug',
        'parent_id',
        'seq',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'seq' => 'integer',
        ];
    }

    public function parent()
    {
        return $this->belongsTo(WebsiteMenu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(WebsiteMenu::class, 'parent_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'menu_id');
    }
}
