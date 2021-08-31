<?php
namespace App\Services\Student;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Jobs\SendMailAddStudentJob;
use App\Models\Student;
use App\Models\User;
use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class StudentService implements StudentServiceInterface {
    protected $studentRepository;
    protected $authRepository;
    public function __construct(StudentRepositoryInterface $studentRepository, AuthRepositoryInterface $authRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->authRepository = $authRepository;
    }
    public function paginate($number){
        return $this->studentRepository->paginate($number);
    }
    public function show(Student $student){
        return $this->studentRepository->show($student);
    }
    public function store(StoreStudentRequest $request)
    {
        $attributesStudent = $request->only(['name','email','phone','content']);
        $student = $this->studentRepository->create($attributesStudent);
        $attributesUser = [
            'name' => $student->name,
            'email' => $student->email,
            'password' => Hash::make('123456789'),
            'avatar' => 'avatar-default.png'
        ];
        $user = $this->authRepository->create($attributesUser);
        dispatch(new SendMailAddStudentJob($student,$user));
        return $student;
    }
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $attributesStudent = $request->only(['name','email','phone','content']);
        $this->studentRepository->update($student,$attributesStudent);
        $user = $this->authRepository->findByEmail($request->oldEmail);
        $this->authRepository->update($user,['email'=>$request->email]);
        $newUser = $this->authRepository->findByEmail($request->email);
        dispatch(new SendMailAddStudentJob($student,$newUser));
        return $student;
    }
    public function destroy(Student $student){
        return $this->studentRepository->destroy($student);
    }
}