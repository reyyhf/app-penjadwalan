<?php

namespace App\Http\Controllers\TataUsaha;

use App\Classroom;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClassroomController extends Controller
{
    public function index(Request $request)
    {
        $classrooms = Classroom::all();

        return view('TataUsaha.Classroom.index', compact('classrooms'));
    }

    public function create()
    {
        return view('TataUsaha.Classroom.create');
    }

    public function store(Request $request)
    {
        $validation_rules = [
            'name' => 'required|string|max:100',
            'class_major' => 'required',
            'total_student' => 'required',
        ];

        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) {
            return redirect()->route('classrooms.create')
                        ->withErrors($validator)->withInput();
        }

        $classroom = new Classroom();
        $classroom->name = $request->input('name');
        $classroom->class_major = $request->input('class_major');
        $classroom->total_student = $request->input('total_student');
        $classroom->save();

        return redirect()->route('classrooms.create')->with([
            'message' => 'Data berhasil disimpan',
        ], 303);
    }

    public function edit(Classroom $classroom)
    {
        return view('TataUsaha.Classroom.edit', compact('classroom'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $validation_rules = [
            'name' => 'required|string|max:100',
            'class_major' => 'required',
            'total_student' => 'required',
        ];

        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) {
            return redirect()->route('classrooms.edit', ['classroom' => $classroom])
                        ->withErrors($validator)->withInput();
        }

        $classroom->name = $request->input('name');
        $classroom->class_major = $request->input('class_major');
        $classroom->total_student = $request->input('total_student');
        $classroom->save();

        return redirect()->route('classrooms.index')->with([
            'message' => 'Data berhasil diubah',
        ], 303);
    }

    public function destroy($id)
    {
        Classroom::find($id)->delete();
        return redirect('/classrooms')->with('message', 'Data berhasil dihapus');
    }
}
