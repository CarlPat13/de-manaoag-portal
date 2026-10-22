<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'user_id',
        'admin_id',
        'first_name',
        'middle_name',
        'last_name',
        'position'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}