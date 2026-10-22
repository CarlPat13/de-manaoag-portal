<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = [
        'user_id',
        'faculty_id',
        'first_name',
        'middle_name',
        'last_name',
        'department',
        'contact_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}