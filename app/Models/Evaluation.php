<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'advisor_id',
        'job_knowledge',
        'analysis',
        'report_presentation',
        'enthusiasm_attitude',
        'work_quality',
        'timeliness',
        'company_job_knowledge',
        'decision_making',
        'reporting_communication',
        'university_weighted_score',
        'company_weighted_score',
        'total_score',
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
