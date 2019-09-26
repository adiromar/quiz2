<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Category;
use App\Roles;
use Illuminate\Support\Facades\Auth;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // one to many relationship
    public function category(){
        return $this->hasMany('App\Category');
    }

    public function profile()
    {
        return $this->hasOne('App\SocialProfile');
    }

    public function getIsAdminAttribute()
    {
        // return $this->roles->pluck( 'roles' )->contains( 'Admin' );
        return $this->roles()->where('role_id', '1')->exists();
    }

    public function isAdmin()
    {   
        $id = Auth::id();
        $role = DB::table('role_user')->where('user_id', $id)->pluck('role_id');
        // return $this->roles->pluck( 'roles' )->contains( 'Admin' );
        // return $this->roles()->where('role_id', '1')->exists();
        return $role[0];
    }

    public function roles(){
        // return $this->belongsToMany( Role::class, 'user_roles'  );
        return $this->belongsToMany('App\Roles');
    }
}
