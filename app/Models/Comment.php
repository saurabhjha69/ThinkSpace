<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function submodule(){
        return $this->belongsTo(Submodule::class,'submodule_id','id');
    }

    public function replies(){
        return $this->hasMany(Comment::class,'parent_id','id');
    }
    public function parent(){
        return $this->belongsTo(Comment::class,'parent_id','id');
    }
    
}
