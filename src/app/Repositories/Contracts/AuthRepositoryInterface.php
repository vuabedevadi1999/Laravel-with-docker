<?php
namespace App\Repositories\Contracts;

use App\Models\User;

interface AuthRepositoryInterface {
    public function findAllUser();
    public function findById($id);
    public function findByEmail($email);
    public function create(array $attributes);
    public function update(User $user,array $attributes);
    public function attachRole(User $user,$roleId);
    public function findRoleStudentByName($name);
}