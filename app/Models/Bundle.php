<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    use HasFactory;

    public function bundledCourses(){
        $this->belongsToMany(Course::class);
    }

    public function createdBy(){
        $this->belongsTo(User::class,'created_by','id');
    }
}
