<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'address',
        'class',
        'section',
        'contact',
        'created_by'
    ];


    public function profile(){
        return $this->hasOne(StudentProfile::class);
    }

    public function createdBy(){
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
