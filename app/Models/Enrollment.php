<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

   protected $fillable = [
    'student_id',
    'class_id',
    'grade'
];

public function student()
{
    return $this->belongsTo(\App\Models\Student::class);
}

public function class()
{
    return $this->belongsTo(\App\Models\ClassModel::class);
}
}