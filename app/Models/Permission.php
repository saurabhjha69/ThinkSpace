<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function roles(){
        return $this->belongsToMany(Role::class,'permission_role');
    }
    public function subpermissions(){
        return $this->belongsToMany(SubPermission::class,'permission_sub_permission');
    }
}
