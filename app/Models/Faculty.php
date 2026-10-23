<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'faculty_id',       // ✅ Ito ang gamit mo sa DB
        'first_name',
        'middle_name',
        'last_name',
        'department',
        'contact_number'     // ✅ Ito ang gamit mo sa DB
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classes()
    {
        return $this->hasMany(ClassModel::class, 'faculty_id');
    }
}