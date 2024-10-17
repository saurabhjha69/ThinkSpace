<?php

namespace App\Models;

use App\Helper\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Submodule extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function module(){
        return $this->belongsTo(Module::class);
    }
    public function course(){
        return $this->module()->where('course_id',$this->module->course_id)->first();
    }

    public function video(){
        return $this->belongsTo(Video::class);
    }
    public function videoLog(){
        return $this->hasOne(VideoUploadLogs::class);
    }
    public function isQueued(){
        return $this->videolog?->where('status','pending')->exists();
    }
    public function videoduration(){
        return Helper::secondsToMinutes($this->video->duration);
    }
    public function comments(){
        return $this->hasMany(Comment::class,'submodule_id','id');
    }




    public function completedSubModules(){
        return $this->hasMany(CompletedSubModule::class,'submodule_id','id');
    }
    public function isMarkedCompleted(){
        return $this->completedSubModules()->where('user_id',Auth::id())->where('submodule_id',$this->id)->where('is_completed',true)->exists();
    }
}
