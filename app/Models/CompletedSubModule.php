<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedSubModule extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function submodule(){
        return $this->belongsTo(Submodule::class,'submodule_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function course(){
        return $this->belongsTo(Course::class,'course_id','id');
    }
}
