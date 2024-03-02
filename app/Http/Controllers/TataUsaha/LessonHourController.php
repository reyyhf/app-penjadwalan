<?php

namespace App\Http\Controllers\TataUsaha;

use App\Classroom;
use App\Http\Controllers\Controller;
use App\LessonHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LessonHourController extends Controller
{
    public function index(Request $request)
    {
        $lessonHours = DB::table('lesson_hours')
            ->select('lesson_hours.*', 'classrooms.name as class_name')
            ->leftjoin('classrooms', 'classrooms.id', '=', 'lesson_hours.class_id')
            ->where('lesson_hours.deleted_at', null)
            ->where('lesson_hours.start_period', date('Y'))
            ->orderBy('lesson_hours.id', 'asc')->get();
        return view('TataUsaha.LessonHour.index', compact('lessonHours'));
    }

    public function create()
    {
        $classrooms = DB::table('classrooms')
            ->select('*')
            ->whereNotIn('id', function ($query) {
                $query->select('class_id')->from('lesson_hours')
                ->where('start_period', date('Y'));
            })
            ->where('deleted_at', null)
            ->get();

        return view('TataUsaha.LessonHour.create', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $validation_rules = [
            'class_id' => 'required',
            'type_curriculum' => 'required',
        ];

        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) {
            return redirect()->route('lesson_hours.create')
                        ->withErrors($validator)->withInput();
        }

        $lessonHour = new LessonHour();
        $lessonHour->class_id = $request->input('class_id');
        $lessonHour->type_curriculum = $request->input('type_curriculum');
        $lessonHour->start_period = date('Y');
        $lessonHour->last_period = date('Y', strtotime('+1 year'));
        $lessonHour->class_id = $request->input('class_id');
        $lessonHour->save();

        return redirect()->route('lesson_hours.create')->with([
            'message' => 'Data berhasil disimpan',
        ], 303);
    }

    public function edit($id)
    {
        $lessonHour = LessonHour::find($id);
        $classroom = Classroom::find($lessonHour->class_id);
        return view('TataUsaha.LessonHour.edit', compact('classroom', 'lessonHour'));
    }

    public function update(Request $request, LessonHour $lessonHour)
    {
        $validation_rules = [
            'type_curriculum' => 'required',
        ];
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) {
            return redirect()->route('lesson_hours.edit', ['lesson_hour' => $lessonHour])
                        ->withErrors($validator)->withInput();
        }

        $lessonHour->type_curriculum = $request->input('type_curriculum');
        $lessonHour->save();

        return redirect()->route('lesson_hours.index')->with([
            'message' => 'Data berhasil diubah',
        ], 303);
    }

    public function destroy($id)
    {
        LessonHour::find($id)->delete();
        return redirect('/lesson-hours')->with('message', 'Data berhasil dihapus');
    }
}
