<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classes;

class Topper extends Model
{
    use HasFactory;

    protected $table = 'toppers';
    protected $appends = ['image_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'school_id',
        'class_id',
        'name',
        'marks',
        'year',
        'image',
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
            'seq' => 'integer',
        ];
    }

    /**
     * Get the class that this topper belongs to.
     */
    public function getImageUrlAttribute()
    {
        return getImageUrl($this->image);
    }
    

   
     public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }


}
