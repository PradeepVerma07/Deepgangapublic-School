<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'school_id',
        'class_id',
        'name',
        'email',
        'mobile',
        'subject',
        'qualification',
        'image',
        'active',
        'seq',
        'dob',
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
            'seq' => 'integer',
        ];
    }

    /**
     * Get the class that this teacher belongs to.
     */
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
