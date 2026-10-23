<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    
    protected $fillable = ['code', 'name', 'units', 'description'];

    public function classes()
    {
        return $this->hasMany(ClassModel::class);
    }
}