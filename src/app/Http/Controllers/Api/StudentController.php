<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Jobs\SendMailAddStudentJob;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Gate::inspect('viewAny',Student::class);
        if($response->allowed()){
            $students = Student::orderBy('created_at','desc')->paginate(5);
            return response()->json(['students'=>$students],200);
        }else{
            return response()->json(["success"=>$response->message()],401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request)
    {
        $response = Gate::inspect('create',Student::class);
        if($response->allowed()){
            $student = Student::create($request->only(['name','email','phone','content']));
            $user = User::create([
                'name' => $student->name,
                'email' => $student->email,
                'password' => Hash::make('123456789'),
                'avatar' => 'avatar-default.png'
            ]);
            dispatch(new SendMailAddStudentJob($student,$user));
            return response()->json(['success'=> __('message.CreatedStudent')],201);
        }else{
            return response()->json(['success' => $response->message()],401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $response = Gate::inspect('view',$student);
        if($response->allowed()){
            $student = Student::find($student->id);
            return response()->json(['student'=>$student],200);
        }else{
            return response()->json(['success' => $response->message()],401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $response = Gate::inspect('update',$student);
        if($response->allowed()){
            $student->update($request->only(['name','email','phone','content']));
            $user = User::where('email',$request->oldEmail)->first();
            $user->update(['email'=>$request->email]);
            $newUser = User::where('email',$request->email)->first();
            dispatch(new SendMailAddStudentJob($student,$newUser));
            return response()->json(['success' => __('message.UpdatedStudent')]);
        }else{
            return response()->json(['success' => $response->message()],401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $response = Gate::inspect('delete',$student);
        if($response->allowed()){
            $student->delete();
            $user = User::where('email',$student->email)->first();
            User::destroy($user->id);
            return response()->json(['success' => __('message.DeletedStudent').$student->id]);
        }else{
            return response()->json(['success' => $response->message()],401);
        }
    }
}
