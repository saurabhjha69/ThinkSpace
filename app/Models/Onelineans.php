<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Onelineans extends Model
{
    use HasFactory;

    public function oneline(){
        return $this->belongsTo(Oneline::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    
}
