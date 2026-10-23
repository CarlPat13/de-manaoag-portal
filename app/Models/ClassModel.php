<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;
    
    protected $table = 'classes';
    
    protected $fillable = [
        'code', 'subject_id', 'faculty_id', 'room', 'schedule', 'year_level', 'description'
    ];

    public function subject() { return $this->belongsTo(Subject::class); }
    public function faculty() { return $this->belongsTo(Faculty::class); }
    public function enrollments() { return $this->hasMany(Enrollment::class, 'class_id'); }
    
    // Ginagamit sa dashboard mo: $c->students->count()
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