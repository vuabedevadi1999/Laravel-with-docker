<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth ;
class AuthController extends Controller
{
    public function login(LoginAuthRequest $request){
        $credenttials = $request->only(['email','password']);
        if(!$token = JWTAuth::attempt($credenttials)){
            return response()->json(['success'=>false],401);
        }
        $user = User::select('id','name')->find(auth()->id());
        return response()->json(['success'=>true,'token'=>$token,'user'=>$user],200);
    }
    public function checkToken(){
        return response()->json(['success'=>true],200);
    }
    public function logout(){
        auth()->logout();
        return response()->json(['success'=>true],200);
    }
    public function userProfile(){
        return response()->json(["user"=>auth()->user()],200);
    }
    public function update(UpdateProfileRequest $request){
        $user = User::find(auth()->id());
        $img = $request->file('file');
        $newImage = date('Ymd').'_'.rand(100000,999999).'.'.$img->getClientOriginalExtension();
        $destinationPath = 'public/images';
        $img->move($destinationPath,$newImage);
        $user->update([
            'name'=> $request->name,
            'email'=> $request->email,
            'avatar' => $newImage,
            'password'=> Hash::make($request->password)
        ]);
        auth()->logout();
        return response()->json(['success'=>true],200);
    }
}
