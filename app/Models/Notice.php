<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $table = 'notices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'school_id',
        'title',
        'message',
        'type',
        'dismissible',
        'start_date',
        'end_date',
        'active',
        'seq',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'dismissible' => 'boolean',
            'seq' => 'integer',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }
}

