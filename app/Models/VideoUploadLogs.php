<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoUploadLogs extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function video(){
        return $this->belongsTo(Video::class);
    }

    public function submodule(){
        return $this->belongsTo(Submodule::class);
    }
    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    
}
