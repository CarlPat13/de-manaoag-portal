<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'student_id',
        'first_name', 'middle_name', 'last_name',
        'course', 'year_level', 'phone', 'address'
    ];

    // ✅ Balik sa User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ Mga Klase na Kinukuha — kailangan para sa Grades page
   public function classes()
{
    return $this->belongsToMany(ClassModel::class, 'enrollments', 'student_id', 'class_id')
        ->withPivot('grade')
        ->withTimestamps();
}

    // ✅ Direktang Enrollments
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }
}