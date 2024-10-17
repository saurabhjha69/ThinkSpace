<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_code', 'discount_percentage', 'discount_amount', 'minimum_order_value',
        'max_discount_amount', 'max_usage_limit', 'max_usages_per_user', 'valid_from',
        'valid_till', 'applies_to', 'description', 'auto_apply', 'one_time_use', 'coupon_type', 'is_active'
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'coupon_course');
    }
    public function users(){
        return $this->belongsToMany(User::class,'coupon_user');
    }
    public function usersUsed(){
        return $this->belongsToMany(User::class,'used_coupon','coupon_id','user_id')->withPivot(['course_id','discount','status','created_at','updated_at']);
    }


    public function isValid(){
        return $this->is_active && $this->valid_from <= now() && $this->valid_till >= now();
    }
    public function isValidForCourse($courseId){
        return $this->courses->contains($courseId);
    }

}
