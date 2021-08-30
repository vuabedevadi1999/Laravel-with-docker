<?php
namespace App\Services\Auth;

use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Repositories\Contracts\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements AuthServiceInterface{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    
    public function login(LoginAuthRequest $request){
        $credenttials = $request->only(['email','password']);
        if(!$token = JWTAuth::attempt($credenttials)){
            return false;
        }
        $user = $this->authRepository->findById(auth()->id());
        return [$token, $user];
    }
    public function checkToken(){
        return true;
    }
    public function logout(){
        auth()->logout();
        return true;
    }
    public function userProfile(){
        return auth()->user();
    }
    public function getRoles(){
        $user = $this->authRepository->findById(auth()->id());
        $roles = array();
        foreach($user->roles as $role){
            $roles[] =  $role->name;
        };
        return $roles;
    }
    public function update(UpdateProfileRequest $request){
        $user = $this->authRepository->findById(auth()->id());
        $img = $request->file('file');
        $newImage = date('Ymd').'_'.rand(100000,999999).'.'.$img->getClientOriginalExtension();
        $destinationPath = 'public/images';
        $img->move($destinationPath,$newImage);
        $user->update([
            'name'=> $request->name,
            'email'=> $request->email,
            'avatar' => $newImage,
            'birthday' => $request->birthday,
            'password'=> Hash::make($request->password)
        ]);
        auth()->logout();
        return true;
    }
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        $existingUser = $this->authRepository->findByEmail($user->email);
        if($existingUser){
            auth()->login($existingUser, true);
            $token = JWTAuth::fromUser($existingUser);
            return [$token, $existingUser];
        } else {
            $newUser = new User;
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->google_id = $user->id;
            $newUser->avatar = $user->avatar;
            $newUser->avatar_type = 1;
            $newUser->save();
            $roleStudent = $this->authRepository->findRoleStudentByName('Student');
            $newUser->roles()->attach($roleStudent->id);
            $token = auth()->login($newUser, true);
            $token = JWTAuth::fromUser($newUser);
            return [$token,$newUser];
        }
    }
    
}