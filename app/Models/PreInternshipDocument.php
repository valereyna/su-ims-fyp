<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreInternshipDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'document_name',
        'document_path',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
