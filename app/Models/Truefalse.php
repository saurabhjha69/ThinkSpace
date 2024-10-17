<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Truefalse extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function quiz(){
        return $this->belongsTo(Quiz::class);
    }

    public function answeredTruefalseans(){
        return $this->hasMany(Truefalseans::class);
    }

    public function usersAnswer($id){
        return $this->answeredTruefalseans()->where('user_id', Auth::id())->where('truefalse_id', $id)->first();
    }
}
