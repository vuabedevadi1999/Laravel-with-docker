<?php
namespace App\Repositories\Contracts;

use App\Models\Student;

interface StudentRepositoryInterface {
    public function paginate($number);
    public function show(Student $student);
    public function destroy(Student $student);
    public function create(array $attributes);
    public function update(Student $student, array $attributes);
}