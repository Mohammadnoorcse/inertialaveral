<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return Inertia::render('Student', [
            'students' => $students,
            'flash' => session('success')
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
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'class' => 'required|string|max:50',
            'section' => 'required|string|max:50',
            'contact' => 'required|string|max:15',
            'address' => 'required|string|max:500'
        ]);

        if ($validation->fails()) {
            return back()->withErrors($validation->errors())->withInput();
        }

        // Store the student data
        $student = Student::create([
            'name' => $request->name,
            'class' => $request->class,
            'section' => $request->section,
            'contact' => $request->contact,
            'address' => $request->address
        ]);

        return redirect()->route('student.index')->with('success', 'Student created successfully');
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



// public function searching(Request $request)
//     {
//         $query = Student::query();

//         if ($request->has('search')) {
//             $search = $request->search;
//             $query->where('name', 'like', "%$search%")
//                 ->orWhere('class', 'like', "%$search%")
//                 ->orWhere('section', 'like', "%$search%")
//                 ->orWhere('contact', 'like', "%$search%")
//                 ->orWhere('address', 'like', "%$search%");
//         }

//         $students = $query->get();

//         return Inertia::render('Student', [
//             'students' => $students,
//             'flash' => session('success'),
//             'search' => $request->search // Keep track of search term
//         ]);
//     }



    