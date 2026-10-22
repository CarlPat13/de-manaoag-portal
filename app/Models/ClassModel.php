<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    // ✅ TAMA: Ang table sa database ay "classes"
    protected $table = 'classes';

    // ✅ Kasama na ang room sa fillable
    protected $fillable = [
        'code',
        'subject_id',
        'faculty_id',
        'schedule',
        'room',        // ✅ DAPAT NANDITO ITO
        'year_level',
        'description'
    ];

    public function subject()
    {
        return $this->belongsTo(\App\Models\Subject::class);
    }

    public function faculty()
    {
        return $this->belongsTo(\App\Models\Faculty::class);
    }

    public function students()
    {
        return $this->hasManyThrough(
            \App\Models\Student::class,
            \App\Models\Enrollment::class,
            'class_id',
            'id',
            'id',
            'student_id'
        );
    }
}