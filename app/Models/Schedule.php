<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['student_id', 'subject_code', 'day', 'time_start', 'time_end', 'room', 'instructor'];
}