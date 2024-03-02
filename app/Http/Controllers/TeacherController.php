<?php

namespace App\Http\Controllers;

use App\Employee;
use App\TeacherLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = collect(Employee::get())->whereIn('position_id', [3,4]);

        return view('teacher.index')->with(compact('teachers'));
    }

    public function show($id)
    {
        // $teacher = Employee::find($id);
        // $lessons = TeacherLesson::where('employee_id',$teacher->id)->get();
        $teacher = Employee::with(['detailLessons' => function($query) {
            $query->with(['curriculumLesson']);
        }])->find($id);

        return view('teacher.detail')->with(compact(['teacher']));
    }

}
