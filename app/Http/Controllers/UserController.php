<?php

namespace App\Http\Controllers;

use App\Position;
use App\User;
use App\Employee;
use App\TeacherLesson;
use App\CurriculumLesson;
use App\CategoryLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $employees = Employee::all();

        return view('user.index')->with(compact('employees'));
    }

    public function create()
    {
        $positions = Position::all('id','name');
        $lessons= CurriculumLesson::with('Categorylesson')->get();
        return view('user.create')->with(compact('positions','lessons'));
    }

    public function store(Request $request)
    {
        $employee = new Employee([
            'position_id' => $request->get('status'),
            'nik' => $request->get('nik'),
            'name' => $request->get('name'),
            'load_teacher' => ($request->get('load_teacher') != 0) ? $request->get('load_teacher') : 0,
            'x_class' => ($request->get('x') == 1) ? $request->get('x') : 0,
            'xi_class' => ($request->get('xi') == 1) ? $request->get('xi') : 0,
            'xii_class' => ($request->get('xii') == 1) ? $request->get('xii') : 0,
        ]);
        $employee->save();
        $employeeId = Employee::all()->max('id');

        $user = new User([
            'employee_id' => $employeeId,
            'position_id' => $request->get('status'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        $user->save();

        if($request->get('status') == 3 || $request->get('status') == 4){
            foreach ($request->get('lesson') as $lesson) {
                $teacherLesson = new TeacherLesson([
                    'employee_id' => $employeeId,
                    'curriculum_id' => $lesson
                ]);
                $teacherLesson->save();
            }

        }

        return redirect()->route('users.create')->with([
            'message' => 'Data berhasil disimpan',
        ], 303);
    }

    public function edit($id)
    {
        $teacherLesson = array();
        $employee = Employee::find($id);
        $user = User::where('employee_id',$id)->first();
        $positions = Position::all('id', 'name');
        // $lessons = CurriculumLesson::all();
        $lessons= CurriculumLesson::with('Categorylesson')->get();
        $data = TeacherLesson::where('employee_id',$employee->id)->get();
        // dd($data);

        foreach ($data as $item) {
            array_push($teacherLesson,$item->curriculum_id);
        }
        // dd($teacherLesson);
        
        return view('user.edit')->with(compact(['employee','user','positions', 'lessons','teacherLesson']));
    }

    public function update(Request $request, $id)
    {
        
        Employee::where("id",$id)->update([
            "position_id" => $request->get('status'),
            "load_teacher" => ($request->get('status') == 1 || $request->get('status') == 2 || $request->get('load_teacher')  < 1) ? 0: $request->get('load_teacher'),
            "x_class" => ($request->get('status') == 1 || $request->get('status') == 2) ? 0: (($request->get('x') !=1) ? 0 : $request->get('x')),
            "xi_class" => ($request->get('status') == 1 || $request->get('status') == 2) ? 0: (($request->get('xi') != 1) ? 0 : $request->get('xi')),
            "xii_class" => ($request->get('status') == 1 || $request->get('status') == 2) ? 0: (($request->get('xii') != 1) ? 0 : $request->get('xii'))
        ]);
        User::where("employee_id",$id)->update(['position_id' => $request->get('status')]);
        TeacherLesson::where("employee_id",$id)->update(["curriculum_id" => $request->get('lesson')]);
        TeacherLesson::where("employee_id",$id)->delete();
        if ($request->get('status') == 3 || $request->get('status') == 4) {
            foreach ($request->get('lesson') as $lesson) {
                $teacherLesson = new TeacherLesson([
                    'employee_id' => $id,
                    'curriculum_id' => $lesson
                ]);
                // dd($teacherLesson);
                $teacherLesson->save();
            }
        }
        return redirect()->route('users.index')->with([
            'message' => 'Data berhasil diperbarui',
        ], 303);
    }

    public function destroy($id)
    {
        $employee = Employee::find($id)->delete();
        $user = User::where("employee_id",$id)->delete();
        $teacherLesson = TeacherLesson::where("employee_id",$id)->delete();

        return redirect()->route('users.index')->with([
            'message' => 'Data berhasil dihapus',
        ], 303);
    }
}
