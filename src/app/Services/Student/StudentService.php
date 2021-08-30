<?php
namespace App\Services\Student;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Jobs\SendMailAddStudentJob;
use App\Models\Student;
use App\Models\User;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class StudentService implements StudentServiceInterface {
    protected $studentRepository;
    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }
    public function paginate($number){
        return $this->studentRepository->paginate($number);
    }
    public function show(Student $student){
        return $this->studentRepository->show($student);
    }
    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->only(['name','email','phone','content']));
        $user = User::create([
            'name' => $student->name,
            'email' => $student->email,
            'password' => Hash::make('123456789'),
            'avatar' => 'avatar-default.png'
        ]);
        dispatch(new SendMailAddStudentJob($student,$user));
        return $student;
    }
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->only(['name','email','phone','content']));
        $user = User::where('email',$request->oldEmail)->first();
        $user->update(['email'=>$request->email]);
        $newUser = User::where('email',$request->email)->first();
        dispatch(new SendMailAddStudentJob($student,$newUser));
        return $student;
    }
    public function destroy(Student $student){
        return $this->studentRepository->destroy($student);
    }
}