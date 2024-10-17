<?php

namespace App\Models;

use App\Helper\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    public function course(){
        return $this->hasOne(Course::class,'id','course_id');
    }
    public function module(){
        return $this->hasOne(Module::class);
    }
    public function submodule(){
        return $this->hasOne(Submodule::class);
    }

    public function stats(){
        return $this->hasMany(VideoStats::class);
    }

    public function watchhrs(){
        return Helper::secondsToMinutes($this->stats()->sum('watch_hours'));
    }
}
