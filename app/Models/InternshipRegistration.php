<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'student_campus_id',
        'advisor_id',
        'company_name',
        'company_address',
        'internship_position',
        'start_date',
        'end_date',
        'additional_notes',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function advisor()
    {
        return $this->belongsTo(User::class, 'advisor_id');
    }
}
