<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // ✅ Relationship — Isang User = Isang Student record
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    // ✅ Relationship — Isang User = Isang Faculty record
    public function faculty()
    {
        return $this->hasOne(Faculty::class);
    }

    // ✅ Relationship — Isang User = Isang Admin record
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
}