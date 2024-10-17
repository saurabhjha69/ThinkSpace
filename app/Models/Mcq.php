<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Mcq extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function quiz(){
        return $this->belongsTo(Quiz::class);
    }

    public function answeredMcqs(){
        return $this->hasMany(Mcqans::class);
    }
    public function usersAnswer(){
        return $this->answeredMcqs()->where('user_id', Auth::user()->id)->where('mcq_id', $this->id);
    }

    
}
