<?php
namespace App\Services\Auth;

use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\UpdateProfileRequest;

interface AuthServiceInterface {
    public function login(LoginAuthRequest $request);
    public function checkToken();
    public function logout();
    public function userProfile();
    public function getRolesAndPermission();
    public function update(UpdateProfileRequest $request);
    public function handleProviderCallback($provider);
}