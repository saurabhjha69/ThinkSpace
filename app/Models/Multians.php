<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Multians extends Model
{
    use HasFactory;

    public function multianswer(){
        return $this->belongsTo(Multianswer::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
