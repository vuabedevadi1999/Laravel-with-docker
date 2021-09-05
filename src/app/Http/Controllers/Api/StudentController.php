<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use App\Services\Student\StudentServiceInterface;
use Illuminate\Support\Facades\Gate;

class StudentController extends Controller
{
    protected $studentService;
    public function __construct(StudentServiceInterface $studentService)
    {
        $this->studentService = $studentService;   
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Gate::inspect('viewAny',Student::class);
        if($response->allowed()){
            $result = $this->studentService->paginate(5);
            return response()->json(['students'=>$result],200);
        }else{
            return response()->json([
                "success"=> false,
                'message' => $response->message()
            ],401);
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
            $result = $this->studentService->store($request);
            return response()->json(['success' => __('message.CreatedStudent'),"data" => $result],201);
        }else{
            return response()->json([
                "success"=> false,
                'message' => $response->message()
            ],401);
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
            $result = $this->studentService->show($student);
            return response()->json([
                'success' => true,
                'student'=>$result
            ],200);
        }else{
            return response()->json([
                "success"=> false,
                'message' => $response->message()
            ],401);
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
            $result = $this->studentService->update($request, $student);
            return response()->json([
                'success' => true,
                'message' => __('message.UpdatedStudent'),
                "data" => $result
            ]);
        }else{
            return response()->json([
                "success"=> false,
                'message' => $response->message()
            ],401);
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
            $result = $this->studentService->destroy($student);
            return response()->json([
                'success' => true,
                'message' => __('message.DeletedStudent').$result->id
            ]);
        }else{
            return response()->json([
                "success"=> false,
                'message' => $response->message()
            ],401);
        }
    }
}
