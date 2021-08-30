<?php
namespace App\Repositories\Eloquent;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Jobs\SendMailAddStudentJob;
use App\Models\Student;
use App\Models\User;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class StudentEloquentRepository implements StudentRepositoryInterface {
    public function paginate($number)
    {
        $students = Student::orderBy('created_at','desc')->paginate($number);
        return $students;
    }
    public function show(Student $student)
    {
        $student = Student::find($student->id);
        return $student;
    }
    public function destroy(Student $student)
    {
        $student->delete();
        $user = User::where('email',$student->email)->first();
        User::destroy($user->id);
        return $student;
    }
}