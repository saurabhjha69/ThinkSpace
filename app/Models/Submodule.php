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

    public function modules(){
        return $this->belongsTo(Module::class);
    }

    public function video(){
        return $this->belongsTo(Video::class);
    }
    public function videoduration(){
        return Helper::secondsToMinutes($this->video->duration);
    }



    public function completedSubModules(){
        return $this->hasMany(CompletedSubModule::class);
    }
    public function isMarkedCompleted(){
        return $this->completedSubModules()->where('user_id',Auth::id())->where('submodule_id',$this->id)->where('is_completed',true)->exists();
    }
}
