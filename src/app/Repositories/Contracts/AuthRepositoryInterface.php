<?php
namespace App\Repositories\Contracts;


interface AuthRepositoryInterface {
    public function findAllUser();
    public function findById($id);
    public function findByEmail($email);
    public function findRoleStudentByName($name);
}