<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $fillable = [
        'school_id',
        'class_id',
        'name',
        'email',
        'mobile',
        'image',
        'address',
        'dob',
        'seq',
        'active',
    ];
    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'seq' => 'integer',
            'dob' => 'date',
        ];
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
