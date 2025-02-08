<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $students = Student::paginate(2);
    //     return Inertia::render('Student', [
    //         'students' => $students,
    //         'flash' => session('success')
    //     ]);
    // }

    public function index(Request $request)
    {

        $search = $request->search ? $request->search : '';

        $students = Student::with(['profile','createdBy:id,name'])
            ->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('class', 'like', '%' . $request->search . '%')
            ->orWhere('section', 'like', '%' . $request->search . '%')
            ->orWhere('contact', 'like', '%' . $request->search . '%')
            ->orWhere('address', 'like', '%' . $request->search . '%')
            ->paginate(2)->appends(['search' => $search]);

        // if ($request->has('search') && !empty($request->search)) {
            // $query->where('name', 'like', '%' . $request->search . '%')
            //     ->orWhere('class', 'like', '%' . $request->search . '%')
            //     ->orWhere('section', 'like', '%' . $request->search . '%')
            //     ->orWhere('contact', 'like', '%' . $request->search . '%')
            //     ->orWhere('address', 'like', '%' . $request->search . '%');
        // }

        // $students = $query->paginate(2)->appends(['search' => $request->search]);

        return Inertia::render('Student', [
            'students' => $students,
            'flash' => session('success'),
            'searchQuery' => $request->search
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'class' => 'required|string|max:50',
            'section' => 'required|string|max:50',
            'contact' => 'required|string|max:15',
            'address' => 'required|string|max:500'
        ]);

        // if ($validation->fails()) {
        //     return back()->withErrors($validation->errors())->withInput();
        // }

        // Store the student data

        $data = [
            'name' => $request->name,
            'class' => $request->class,
            'section' => $request->section,
            'contact' => $request->contact,
            'address' => $request->address,
            'created_by' => Auth::user()->id
        ];

        $student = Student::create($data);

        $student->profile()->create([
            'student_id' => $student->id,
            'name' => 'roton exaple'
        ]);

        // StudentProfile::create([
        //     'student_id' => $student->id,
        //     'name' => 'roton exaple'
        // ]);


        // return redirect()->route('student.index')->with('success', 'Student created successfully');
        return response()->json(['success' =>  $student->id]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return back()->withErrors('error', 'Not found the Id');
        }

        return Inertia::render('Edit', [
            "student" => $student
        ], 201)->with('success', 'Student single successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return back()->withErrors('error', 'Not found the Id');
        }

        $student->update([
            "name" => $request->name,
            "address" => $request->address,
            "class" => $request->class,
            "section" => $request->section,
            "contact" => $request->contact,
        ]);

        return redirect()->route('student.index')->with('success', 'Student Update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return back()->withErrors(['message' => 'Student not found']);
        }
        $student->delete();
        return redirect()->route('student.index')->with('success', 'Student deleted successfully');
    }
}


