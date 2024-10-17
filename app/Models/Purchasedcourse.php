<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchasedcourse extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function purchaser(){
        return $this->belongsTo(User::class);
    }
    public function payment(){
        return $this->hasMany(Payment::class);
    }

}
