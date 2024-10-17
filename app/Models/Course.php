<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user')->withPivot(['enrolled_at', 'status']);
    }
    public function isUserEnrolled()
    {
        return $this->users()->where('user_id', Auth::id())->where('course_id', $this->id)->first()?->pivot;
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function approvalRequest()
    {
        return $this->hasOne(CourseApproval::class);
    }


    public function approvalLogs()
    {
        return DB::table('course_approval_logs')->where('course_id', $this->id)->get();
    }


    public function isApproved()
    {
        return $this->approvalRequest()->where('status', 'approved')->exists();
    }

    public function isRejected()
    {
        return $this->approvalRequest()->where('status', 'rejected')->exists();
    }
    public function isPending()
    {
        return $this->approvalRequest()->where('status', 'pending')->exists();
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }



    public function queuedSubModules()
    {
        $counter = 0;
        foreach ($this->modules as $module) {
            foreach ($module->submodules as $submodule) {
                if ($submodule->isQueued()) {
                    $counter++;
                }
            }
        }
        return $counter;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
    public function submodules()
    {
        return $this->hasManyThrough(SubModule::class, Module::class);
    }
    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'course_id', 'id');
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
    public function enrolledStudents()
    {
        return $this->users->where('status', 'enrolled')->get();
    }
    public function ratedStarAvg($star)
    {
        $totalCount = $this->ratings()->where('course_id', $this->id)->count();
        $starCount = $this->ratings()->where('course_id', $this->id)->where('stars', $star)->count();
        return $totalCount == 0 ? 0 : ($starCount / $totalCount) * 100;
    }
    public function hasUserRated()
    {
        return $this->ratings()->where('course_id', $this->id)->where('user_id', Auth::id())->exists();
    }



    public function prerequisites()
    {
        return $this->belongsToMany(Prerequisite::class);
    }

    public function introvideo()
    {
        return $this->belongsTo(Video::class, 'video_id', 'id');
    }

    public function purchasedCourses()
    {
        return $this->hasMany(Purchasedcourse::class);
    }

    public function totalWatchHours()
    {
        $totalDuration = 0;
        foreach ($this->users as $user) {
            $totalDuration += $user->totalWatchHours();
        }
        return $totalDuration == 0 ? 0 : $totalDuration;
    }

    // public function courseWatchHours(){
    //     $totalWatchHours = Video::whereHas('submodule.module', function ($query) {
    //         $query->where('course_id', $this->id);
    //     })->sum('watch_hours');
    //     return $totalWatchHours;
    // }

    public function courseWatchHours()
    {
        $totalWatchHours = $this->submodules()
            ->join('videos', 'submodules.video_id', '=', 'videos.id')
            ->join('video_stats', 'videos.id', '=', 'video_stats.video_id')
            ->sum('video_stats.watch_hours');
        return $totalWatchHours;
    }


    public function averageRating()
    {
        // Assuming 'ratings' is the relationship name
        $totalRatings = $this->ratings()->avg('stars');

        return $totalRatings !== null ? round($totalRatings, 1) : 0;
    }

    public function totalCourseDuration()
    {
        $totalDuration = 0;
        foreach ($this->modules as $module) {
            $totalDuration += $module->totalDuration();
        }
        return $totalDuration;
    }

    public function lectures($param)
    {
        $lectures = 0;
        foreach ($this->modules as $module) {
            foreach ($module->submodules as $submodule) {
                if ($submodule->video) {
                    $lectures++;
                }
            }
        }
        return $lectures;
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'course_id', 'id');
    }

    public function totalSales()
    {
        return $this->payments()->where('payment_status', 'paid')->sum('amount');
    }

    public function isCoursePurchased($id)
    {
        return $this->payments()
            ->where('user_id', $id)
            ->where('status', 'complete')
            ->where('payment_status', 'paid')
            ->exists();
    }

    public function calcDiscount(Course $course)
    {
        $current_price = $course->price;
        $est_price = $course->est_price;
        $discount_amount = $est_price - $current_price;
        $discount_perc = ($discount_amount * 100) / $est_price;
        return round($discount_perc, 2);
    }

    public function progress()
    {
        $moduleCount = $this->modules()->count();
        $completedSubModuleValue = 0;
        foreach ($this->modules()->get() as $module) {
            $completedSubModuleValue += $module->howMuchCompleted();
        }
        if ($moduleCount === 0) {
            return 0;
        }
        $completedPercentage = $completedSubModuleValue / $moduleCount;
        return round($completedPercentage);
        // return 70;
    }
    public function completedSubModules()
    {
        return $this->hasMany(CompletedSubModule::class, 'course_id', 'id');
    }

    public function userCompletedSubModules($user_id)
    {
        $moduleCount = $this->submodules()->count();
        $completedSubModules = $this->completedSubModules()
            ->select('is_completed', 'submodule_id')
            ->where('course_id', $this->id)
            ->where('user_id', $user_id)
            // ->groupBy('is_completed')
            ->where('is_completed', true)
            ->count();
        return round($completedSubModules / $moduleCount * 100);
    }

    public function subModulesWatchDuration(){
        return $this->submodules()
        ->join('video_stats', 'submodules.video_id', '=', 'video_stats.video_id')
        ->select('submodules.title as video_name','video_stats.video_id as video_id',DB::raw('SUM(video_stats.watch_hours) as total_watch_hours'))
        ->groupBy('submodules.id')
        ->get();
        // return $this->submodules->pluck('id');
    }

    public function isUserCompletedCourse($user_id){
        return $this->userCompletedSubModules($user_id) == 100 ? true : false;
    }

    //course_bundles

    public function bundles()
    {
        $this->belongsToMany(Bundle::class);
    }

    public function activeCoupons()
    {
        return $this->belongsToMany(Coupon::class,'coupon_course');
    }

    public function usedCoupons(){
        return $this->belongsToMany(Coupon::class,'used_coupon','course_id','coupon_id')->withPivot(['user_id','discount','status','created_at','updated_at']);
    }

}
