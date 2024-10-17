<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        return $this->hasOne(Userinfo::class);
    }
    public function courses(){
        return $this->hasMany(Course::class);
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

    public function  attemptedquizzes(){
        return $this->hasMany(Attemptedquiz::class);
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
