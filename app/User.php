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
        'name', 'email',
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
        $user = Auth::user();
        $role = $user->checkRole( Auth::id() );
        return $role; 
    }

    public function checkRole($id){

        $role = DB::table('role_user')->where('user_id', $id)->pluck('role_id')->first();
        
        switch ($role) {
            case 1:
                return "SuperAdmin";
                break;
            case 2:
                return "Admin";
                break;
            default:
                return "User";
                break;
        }

    }

    public function roles(){
        // return $this->belongsToMany( Role::class, 'user_roles'  );
        return $this->belongsToMany('App\Roles', 'role_user', 'role_id', 'user_id');
    }

    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }
    
}
