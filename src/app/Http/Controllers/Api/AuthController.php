<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\Auth\AuthServiceInterface;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;   
    }
    public function login(LoginAuthRequest $request){
        $result = $this->authService->login($request);
        if($result){
            return response()->json(['success'=>true,'token'=>$result[0],'user'=>$result[1]],200);
        }
    }
    public function checkToken(){
        $result = $this->authService->checkToken();
        if($result){
            return response()->json(['success'=>true],200);
        }
    }
    public function logout(){
        $result = $this->authService->logout();
        if($result){
            return response()->json(['success'=>true],200);
        }
    }
    public function userProfile(){
        $result = $this->authService->userProfile();
        if($result){
            return response()->json(['user' => $result],200);
        }
    }
    public function getRoles(){
        $result = $this->authService->getRoles();
        if($result){
            return response()->json(['roles' => $result],200);
        }
    }
    public function update(UpdateProfileRequest $request){
        $result = $this->authService->update($request);
        if($result){
            return response()->json(['success'=>true],200);
        }
    }
    public function handleProviderCallback($provider)
    {
        $result = $this->authService->handleProviderCallback($provider);
        if($result){
            return response()
            ->json(['success'=>true,'token'=>$result[0],'user'=>$result[1]],200);
        }
    }
}
