<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use Illuminate\Support\Facades\Log;

class AdmissionRequest extends Model
{
    use HasFactory;

    protected $table = 'admission_requests';

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
        'address',
        'dob',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'dob' => 'date',
            'status' => 'string',
        ];
    }

    /**
     * Get the class that this admission request belongs to.
     */
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Boot the model and handle status changes.
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function ($admissionRequest) {
            if ($admissionRequest->wasChanged('status') && $admissionRequest->status === 'Approved') {
                try {
                    Student::create([
                        'class_id' => $admissionRequest->class_id,
                        'name' => $admissionRequest->name,
                        'email' => $admissionRequest->email,
                        'mobile' => $admissionRequest->mobile,
                        'address' => $admissionRequest->address,
                        'dob' => $admissionRequest->dob,
                        'image' => config('app.DEFAULT_IMAGE') . 'default-student.jpg',
                        'seq' => 0,
                        'active' => true,
                    ]);
                    Log::info('Admission request approved and student created: ' . $admissionRequest->name, ['user_id' => auth()->id()]);
                } catch (\Exception $e) {
                    Log::error('Failed to create student from admission request: ' . $e->getMessage(), ['admission_request_id' => $admissionRequest->id]);
                }
            }
        });
    }
}
