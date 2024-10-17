<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function model(){
        return $this->belongsTo(Module::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function mcqs(){
        return $this->hasMany(Mcq::class);
    }
    public function onelines(){
        return $this->hasMany(Oneline::class);
    }
    public function multians(){
        return $this->hasMany(Multianswer::class);
    }
    public function truefalse(){
        return $this->hasMany(Truefalse::class);
    }

    public function attemptedquizzes(){
        return $this->hasMany(Attemptedquiz::class);
    }
}
