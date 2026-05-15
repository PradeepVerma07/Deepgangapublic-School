<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $table = 'sections';

    protected $fillable = [
        'school_id',
        'menu_id',
        'type',
        'content',
        'heading',
        'file_path',
        'seq',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'seq' => 'integer',
            'type' => 'string',
        ];
    }

    public function menu()
    {
        return $this->belongsTo(WebsiteMenu::class, 'menu_id');
    }
}
