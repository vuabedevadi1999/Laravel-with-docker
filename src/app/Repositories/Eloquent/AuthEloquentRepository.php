<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthEloquentRepository implements AuthRepositoryInterface
{
    public function findAllUser(){
        return User::all();
    }
    public function findById($id){
        return User::find($id);
    }
    public function findByEmail($email){
        return User::where('email',$email)->first();
    }
    public function findRoleStudentByName($name){
        return Role::where('name',$name)->first();
    }
    public function create($attributes){
        return User::create($attributes);
    }
    public function update(User $user, $attributes){
        return $user->update($attributes);
    }
    public function attachRole(User $user,$roleId){
        return $user->roles()->attach($roleId);
    }
}