<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truefalseans extends Model
{
    use HasFactory;

    public function mcq(){
        return $this->belongsTo(Mcq::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    
}
