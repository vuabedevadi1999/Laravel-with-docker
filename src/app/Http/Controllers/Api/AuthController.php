<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth ;
use Socialite;
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
    /**
  * Redirect the user to the Google authentication page.
  *
    * @return \Illuminate\Http\Response
    */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }
    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser){
            auth()->login($existingUser, true);
            $token = JWTAuth::fromUser($existingUser);
            return response()->json(['success'=>true,'token'=>$token,'user'=>$existingUser],200);
        } else {
            $newUser = new User;
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->google_id = $user->id;
            $newUser->avatar = $user->avatar;
            $newUser->avatar_type = 1;
            $newUser->save();
            $roleStudent = Role::where('name','Student')->first();
            $newUser->roles()->attach($roleStudent->id);
            $token = auth()->login($newUser, true);
            $token = JWTAuth::fromUser($newUser);
            return response()->json(['success'=>true,'token'=>$token,'user'=>$newUser],200);
        }
    }
}
