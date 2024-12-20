<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function purchaser(){
        return $this->belongsTo(User::class);
    }

    public function course(){
        return $this->belongsTo(Course::class,'course_id','id');
    }
    
}
