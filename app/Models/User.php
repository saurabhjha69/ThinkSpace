<?php

namespace App\Models;

use App\Helper\Helper;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userinfo(){
        return $this->hasOne(Userinfo::class,'user_id','id');
    }

    public function fullname(){
        return $this->userinfo?->firstname.' '.$this->userinfo?->lastname;
    }

    public function courses(){
        return $this->belongsToMany(Course::class,'course_user')->withPivot(['enrolled_at','status']);
    }
    public function createdCategoryPrices(){
        return $this->hasMany(CategoryPrice::class,'created_by','id');
    }
    public function completedBy(){
        return $this->courses->where('status','completed');
    }
    public function isEnrolled($id){
        return $this->courses()->where('course_id',$id)->exists();
    }
    public function createdCourses(){
        return $this->hasMany(Course::class,'user_id','id');
    }



    public function approvals(){
        return $this->hasMany(CourseApproval::class);
    }

    public function instructorRating(){
        $totalRating = 0;
        foreach($this->createdCourses as $course){
            $totalRating += $course?->averageRating();
        }
        $avgRating = $totalRating / $this->createdCourses->count();
        return $avgRating!=null ? round($avgRating, 1) : 0;
    }
    public function totalRatings(){
        $count = 0;
        foreach($this->createdCourses as $course){
            $count += $course->ratings->count();
        }
        return $count != null ? $count : 0;
    }

    public function totalEnrolledStudents(){
        $count = 0;
        foreach($this->createdCourses as $course){
            $count += $course->users->count();
        }
        return $count != null ? $count : 0;
    }
    public function enrolledStudents(){
        return $this->createdCourses()
        ->join('course_user','course_user.course_id','courses.id')
        ->join('users','users.id','course_user.user_id')
        ->where('course_user.status','enrolled')
        ->select('users.id as user_id','users.username as username','users.email as user_email','course_user.enrolled_at as user_enrolled_at','courses.id as course_id','courses.name as course_name')
        ->get();

    }
    public function totalWatchHourseOnAllCourses(){
        $totalHours = 0;
        foreach($this->createdCourses as $course){
            $totalHours += $course->courseWatchHours();
        }
        return $totalHours;
    }

    public function totalWatchHours(){
        $watchhrs = $this->hasMany(VideoStats::class,'user_id','id')->sum('watch_hours');
        // dd((float)Helper::secondsToMinutes($watchhrs));
        return $watchhrs;
    }

    public function isEnrolledByAdmin($user_id,$course_id){
        return DB::table('enrolled_users_by_admin')->where('course_id',$course_id)->where('learner_id',$user_id)->exists();
    }
    public function quizzes(){
        return $this->hasMany(Quiz::class);
    }
    public function ratings(){
        return $this->hasMany(Rating::class);
    }
    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function isAdmin(){
        return $this->hasRole('admin');
    }


    public function isInstructor(){
        return $this->hasRole('instructor');
    }
    public function isStudent(){
        return $this->hasRole('student
        ');
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function attemptedquizzes(){
        return $this->belongsToMany(Quiz::class,'attemptedquizzes')->withPivot(['marks','created_at','total_correct_ans','total_attempted_ans']);
    }

    public function roles(){
        return $this->belongsToMany(Role::class,'role_user');
    }
    public function hasRole($role){
        return $this->roles->contains('name',$role);
    }

    public function answeredMcqs(){
        return $this->hasMany(Mcqans::class);
    }
    public function answeredMultians(){
        return $this->hasMany(Multians::class);
    }
    public function answeredTruefalseans(){
        return $this->hasMany(Truefalseans::class);
    }
    public function answeredOnelineans(){
        return $this->hasMany(Onelineans::class);
    }


    public function bundles(){
        return $this->hasMany(Bundle::class,'created_by','id');
    }
    public function coupons(){
        $this->belongsToMany(Coupon::class,'coupon_user');

    }
    public function couponsUsed(){
        return $this->belongsToMany(Coupon::class,'used_coupon','user_id','coupon_id')->withPivot(['course_id','discount','status','created_at','updated_at']);
    }












     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
