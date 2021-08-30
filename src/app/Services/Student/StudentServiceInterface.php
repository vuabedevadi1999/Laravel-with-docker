<?php
namespace App\Services\Student;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;

interface StudentServiceInterface {
    public function paginate($number);
    public function store(StoreStudentRequest $request);
    public function update(UpdateStudentRequest $request, Student $student);
    public function destroy(Student $student);
    public function show(Student $student);
}