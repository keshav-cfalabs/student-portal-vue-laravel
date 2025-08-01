<?php

namespace App\Http\Controllers\students;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\StudentResource;
use App\Models\Classes;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function index()
    {
      
           $students = Student::query()
           ->when(request('search'), function ($query) {
               $query->where('name', 'like', '%' . request('search') . '%')
                     ->orWhere('email', 'like', '%' . request('search') . '%');
           })
           ->with(['class', 'section'])->paginate(10);
        $students = StudentResource::collection($students);
        return inertia('Students/Index', [
            'students' => $students,
        ]);
    }


    public function create()
    {

        $classes = ClassesResource::collection(Classes::all());

        return inertia('Students/Create', [
            'classes' => $classes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        $validated = $request->validated();
        Student::create($validated);
        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return inertia('Students/Edit', [
            'student' => new StudentResource($student->load(['class', 'section'])),
            'classes' => ClassesResource::collection(Classes::all())
        ]);
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->validated());
        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
