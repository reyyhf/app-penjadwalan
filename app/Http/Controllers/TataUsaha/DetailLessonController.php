<?php

namespace App\Http\Controllers\TataUsaha;

use App\Classroom;
use App\CurriculumLesson;
use App\DetailLesson;
use App\Employee;
use App\Http\Controllers\Controller;
use App\LessonHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DetailLessonController extends Controller
{
    public function index(Request $request, $id)
    {
        $lessonHour = LessonHour::find($id);
        $classroom = Classroom::find($lessonHour->class_id);
        $days = DB::table('days')->get();
        $lessonarray = DB::table('detail_lessons')
            ->select('curriculum_id')
            ->where('lesson_hour_id', '=', $lessonHour->id)
            ->get();

        $curriculumLessons = DB::table('curriculum_lessons')
            ->select('curriculum_lessons.id', 'curriculum_lessons.name_lesson', 'employees.name as name_employee', $lessonHour->type_curriculum.' as weight')
            // ->select('curriculum_lessons.id', 'curriculum_lessons.name_lesson', $lessonHour->type_curriculum . ' as weight')
            ->leftJoin('employees', 'employees.id', '=', 'curriculum_lessons.employee_id')
            ->whereNotIn('curriculum_lessons.id', DB::table('detail_lessons')
            ->select('detail_lessons.curriculum_id')
            ->where('detail_lessons.lesson_hour_id', '=', $lessonHour->id))
            ->where($lessonHour->type_curriculum, '<>', '')
            ->where('curriculum_lessons.deleted_at', null)->get();

        $detailLessons = DB::table('detail_lessons')
            ->select('detail_lessons.*', 'days.name as day_name', 'curriculum_lessons.name_lesson', 'employees.name as teacher_name')
            ->leftjoin('days', 'days.id', '=', 'detail_lessons.day')
            ->leftjoin('curriculum_lessons', 'curriculum_lessons.id', '=', 'detail_lessons.curriculum_id')
            ->leftjoin('employees', 'employees.id', '=', 'detail_lessons.employee_id')
            ->where('detail_lessons.lesson_hour_id', $id)
            ->orderBy('detail_lessons.day', 'asc')
            ->orderBy('detail_lessons.hour', 'asc')->get();

        $teachers = collect(Employee::get())->whereIn('position_id', [3, 4]);

        return view('TataUsaha.LessonHour.DetailLesson.index', compact('lessonHour', 'classroom', 'curriculumLessons', 'days', 'detailLessons', 'teachers'));
    }

    public function store(Request $request, $id)
    {
        $weight = $request->input('weight');
        $curriculum_id = $request->input('curriculum_id');
        $day = $request->input('day');
        $teacher_id = $request->input('teacher_id');
        $hour = $request->input('hour');

        $day1 = $request->input('day1');
        $teacher_id_1 = $request->input('teacher_id_1');
        $hour1 = $request->input('hour1');
        $hour2 = $request->input('hour2');

        $day2 = $request->input('day2');
        $teacher_id_2 = $request->input('teacher_id_2');
        $hour3 = $request->input('hour3');
        $hour4 = $request->input('hour4');
        $detailLessons = DetailLesson::all();

        if ($weight == 1) {
            $validation_rules = [
                'curriculum_id' => 'required',
                'day' => 'required',
                'teacher_id' => 'required',
                'hour' => 'required',
            ];
        } elseif ($weight == 2) {
            $validation_rules = [
                'curriculum_id' => 'required',
                'day1' => 'required',
                'teacher_id_1' => 'required',
                'hour1' => 'required',
            ];
        } elseif ($weight == 3) {
            $validation_rules = [
                'curriculum_id' => 'required',
                'day' => 'required',
                'teacher_id' => 'required',
                'hour' => 'required',
                'day1' => 'required',
                'teacher_id_1' => 'required',
                'hour1' => 'required',
            ];
        } elseif ($weight == 4) {
            $validation_rules = [
                'curriculum_id' => 'required',
                'day1' => 'required',
                'teacher_id_1' => 'required',
                'hour1' => 'required',
                'day2' => 'required',
                'teacher_id_2' => 'required',
                'hour3' => 'required',
            ];
        }

        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) {
            return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])
                ->withErrors($validator)->withInput();
        }


        if ($weight == 3) {
            if ($day == $day1) {
                if ($hour == $hour1 || $hour == $hour2) {
                    return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
                        'gagal' => 'Data hari dan jam crash',
                    ], 303);
                }
            }
        } elseif ($weight == 4) {
            if ($day1 == $day2) {
                if ($hour1 == $hour3 || $hour1 == $hour4) {
                    return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
                        'gagal' => 'Data hari dan jam crash',
                    ], 303);
                } elseif ($hour2 == $hour3 || $hour2 == $hour4) {
                    return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
                        'gagal' => 'Data hari dan jam crash',
                    ], 303);
                }
            }
        }


        foreach ($detailLessons as $key => $detailLesson) {
            if ($weight == 1) {
                if ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day && $detailLesson->hour == $hour) {
                    return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
                        'gagal' => 'Data hari dan jam tidak tersedia',
                    ], 303);
                }
            } elseif ($weight == 2) {

                if ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day1 && $detailLesson->hour == $hour1) {
                    return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
                        'gagal' => 'Data hari dan jam tidak tersedia',
                    ], 303);
                } elseif ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day1 && $detailLesson->hour == $hour2) {
                    return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
                        'gagal' => 'Data hari dan jam tidak tersedia',
                    ], 303);
                }
            } elseif ($weight == 3) {
                if ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day && $detailLesson->hour == $hour) {
                    return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
                        'gagal' => 'Data hari dan jam tidak tersedia',
                    ], 303);
                } elseif ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day1 && $detailLesson->hour == $hour1) {
                    return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
                        'gagal' => 'Data hari dan jam tidak tersedia',
                    ], 303);
                } elseif ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day1 && $detailLesson->hour == $hour2) {
                    return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
                        'gagal' => 'Data hari dan jam tidak tersedia',
                    ], 303);
                }
            } elseif ($weight == 4) {
                if ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day1 && $detailLesson->hour == $hour1) {
                    return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
                        'gagal' => 'Data hari dan jam tidak tersedia',
                    ], 303);
                } elseif ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day1 && $detailLesson->hour == $hour2) {
                    return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
                        'gagal' => 'Data hari dan jam tidak tersedia',
                    ], 303);
                } elseif ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day2 && $detailLesson->hour == $hour3) {
                    return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
                        'gagal' => 'Data hari dan jam tidak tersedia',
                    ], 303);
                } elseif ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day2 && $detailLesson->hour == $hour4) {
                    return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
                        'gagal' => 'Data hari dan jam tidak tersedia',
                    ], 303);
                }
            }
        }

        if ($weight == 1) {
            $detailLesson = new DetailLesson();
            $detailLesson->lesson_hour_id = $id;
            $detailLesson->curriculum_id = $curriculum_id;
            $detailLesson->employee_id = $teacher_id;
            $detailLesson->day = $day;
            $detailLesson->hour = $hour;
            $detailLesson->weight = 1;
            $detailLesson->save();
        } elseif ($weight == 2) {
            $detailLesson = new DetailLesson();
            $detailLesson->lesson_hour_id = $id;
            $detailLesson->curriculum_id = $curriculum_id;
            $detailLesson->employee_id = $teacher_id_1;
            $detailLesson->day = $day1;
            $detailLesson->hour = $hour1;
            $detailLesson->weight = 1;
            $detailLesson->save();

            $detailLesson = new DetailLesson();
            $detailLesson->lesson_hour_id = $id;
            $detailLesson->curriculum_id = $curriculum_id;
            $detailLesson->employee_id = $teacher_id_1;
            $detailLesson->day = $day1;
            $detailLesson->hour = $hour2;
            $detailLesson->weight = 1;
            $detailLesson->save();
        } elseif ($weight == 3) {
            $detailLesson = new DetailLesson();
            $detailLesson->lesson_hour_id = $id;
            $detailLesson->curriculum_id = $curriculum_id;
            $detailLesson->employee_id = $teacher_id;
            $detailLesson->day = $day;
            $detailLesson->hour = $hour;
            $detailLesson->weight = 1;
            $detailLesson->save();

            $detailLesson = new DetailLesson();
            $detailLesson->lesson_hour_id = $id;
            $detailLesson->curriculum_id = $curriculum_id;
            $detailLesson->employee_id = $teacher_id_1;
            $detailLesson->day = $day1;
            $detailLesson->hour = $hour1;
            $detailLesson->weight = 1;
            $detailLesson->save();

            $detailLesson = new DetailLesson();
            $detailLesson->lesson_hour_id = $id;
            $detailLesson->curriculum_id = $curriculum_id;
            $detailLesson->employee_id = $teacher_id_1;
            $detailLesson->day = $day1;
            $detailLesson->hour = $hour2;
            $detailLesson->weight = 1;
            $detailLesson->save();
        } elseif ($weight == 4) {
            $detailLesson = new DetailLesson();
            $detailLesson->lesson_hour_id = $id;
            $detailLesson->curriculum_id = $curriculum_id;
            $detailLesson->employee_id = $teacher_id_1;
            $detailLesson->day = $day1;
            $detailLesson->hour = $hour1;
            $detailLesson->weight = 1;
            $detailLesson->save();

            $detailLesson = new DetailLesson();
            $detailLesson->lesson_hour_id = $id;
            $detailLesson->curriculum_id = $curriculum_id;
            $detailLesson->employee_id = $teacher_id_1;
            $detailLesson->day = $day1;
            $detailLesson->hour = $hour2;
            $detailLesson->weight = 1;
            $detailLesson->save();

            $detailLesson = new DetailLesson();
            $detailLesson->lesson_hour_id = $id;
            $detailLesson->curriculum_id = $curriculum_id;
            $detailLesson->employee_id = $teacher_id_2;
            $detailLesson->day = $day2;
            $detailLesson->hour = $hour3;
            $detailLesson->weight = 1;
            $detailLesson->save();

            $detailLesson = new DetailLesson();
            $detailLesson->lesson_hour_id = $id;
            $detailLesson->curriculum_id = $curriculum_id;
            $detailLesson->employee_id = $teacher_id_2;
            $detailLesson->day = $day2;
            $detailLesson->hour = $hour4;
            $detailLesson->weight = 1;
            $detailLesson->save();
        }

        $lessonHour = LessonHour::find($id);
        $total_details = DB::table('detail_lessons')
            ->selectRaw('SUM(weight) as total_weight')
            ->selectRaw('(Select SUM(' . $lessonHour->type_curriculum . ') from curriculum_lessons where ' . $lessonHour->type_curriculum . ' is not null) total_lesson')
            ->where('lesson_hour_id', $id)
            ->get();

        foreach ($total_details as $key => $total_detail) {
            if ($total_detail->total_weight == $total_detail->total_lesson) {
                $lessonHour->status = 1;
                $lessonHour->save();
            }
        }

        return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
            'message' => 'Data berhasil disimpan',
        ], 303);
    }
    
    // public function store(Request $request, $id)
    // {
    //     $weight = $request->input('weight');
    //     $curriculum_id = $request->input('curriculum_id');
    //     $day = $request->input('day');
    //     $hour = $request->input('hour');
    //     $day1 = $request->input('day1');
    //     $hour1 = $request->input('hour1');
    //     $hour2 = $request->input('hour2');
    //     $day2 = $request->input('day2');
    //     $hour3 = $request->input('hour3');
    //     $hour4 = $request->input('hour4');
    //     $detailLessons = DetailLesson::all();

    //     if ($weight == 1) {
    //         $validation_rules = [
    //             'curriculum_id' => 'required',
    //             'day' => 'required',
    //             'hour' => 'required',
    //         ];
    //     } elseif ($weight == 2) {
    //         $validation_rules = [
    //             'curriculum_id' => 'required',
    //             'day1' => 'required',
    //             'hour1' => 'required',
    //         ];
    //     } elseif ($weight == 3) {
    //         $validation_rules = [
    //             'curriculum_id' => 'required',
    //             'day' => 'required',
    //             'hour' => 'required',
    //             'day1' => 'required',
    //             'hour1' => 'required',
    //         ];
    //     } elseif ($weight == 4) {
    //         $validation_rules = [
    //             'curriculum_id' => 'required',
    //             'day1' => 'required',
    //             'hour1' => 'required',
    //             'day2' => 'required',
    //             'hour3' => 'required',
    //         ];
    //     }

    //     $validator = Validator::make($request->all(), $validation_rules);

    //     if ($validator->fails()) {
    //         return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])
    //             ->withErrors($validator)->withInput();
    //     }

    //     if ($weight == 3) {
    //         if ($day == $day1) {
    //             if ($hour == $hour1 || $hour == $hour2) {
    //                 return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
    //                     'gagal' => 'Data hari dan jam crash',
    //                 ], 303);
    //             }
    //         }
    //     } elseif ($weight == 4) {
    //         if ($day1 == $day2) {
    //             if ($hour1 == $hour3 || $hour1 == $hour4) {
    //                 return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
    //                     'gagal' => 'Data hari dan jam crash',
    //                 ], 303);
    //             } elseif ($hour2 == $hour3 || $hour2 == $hour4) {
    //                 return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
    //                     'gagal' => 'Data hari dan jam crash',
    //                 ], 303);
    //             }
    //         }
    //     }

    //     foreach ($detailLessons as $key => $detailLesson) {
    //         if ($weight == 1) {
    //             if ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day && $detailLesson->hour == $hour) {
    //                 return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
    //                     'gagal' => 'Data hari dan jam tidak tersedia',
    //                 ], 303);
    //             }
    //         } elseif ($weight == 2) {
    //             if ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day1 && $detailLesson->hour == $hour1) {
    //                 return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
    //                     'gagal' => 'Data hari dan jam tidak tersedia',
    //                 ], 303);
    //             } elseif ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day1 && $detailLesson->hour == $hour2) {
    //                 return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
    //                     'gagal' => 'Data hari dan jam tidak tersedia',
    //                 ], 303);
    //             }
    //         } elseif ($weight == 3) {
    //             if ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day && $detailLesson->hour == $hour) {
    //                 return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
    //                     'gagal' => 'Data hari dan jam tidak tersedia',
    //                 ], 303);
    //             } elseif ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day1 && $detailLesson->hour == $hour1) {
    //                 return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
    //                     'gagal' => 'Data hari dan jam tidak tersedia',
    //                 ], 303);
    //             } elseif ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day1 && $detailLesson->hour == $hour2) {
    //                 return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
    //                     'gagal' => 'Data hari dan jam tidak tersedia',
    //                 ], 303);
    //             }
    //         } elseif ($weight == 4) {
    //             if ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day1 && $detailLesson->hour == $hour1) {
    //                 return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
    //                     'gagal' => 'Data hari dan jam tidak tersedia',
    //                 ], 303);
    //             } elseif ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day1 && $detailLesson->hour == $hour2) {
    //                 return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
    //                     'gagal' => 'Data hari dan jam tidak tersedia',
    //                 ], 303);
    //             } elseif ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day2 && $detailLesson->hour == $hour3) {
    //                 return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
    //                     'gagal' => 'Data hari dan jam tidak tersedia',
    //                 ], 303);
    //             } elseif ($detailLesson->lesson_hour_id == $id && $detailLesson->day == $day2 && $detailLesson->hour == $hour4) {
    //                 return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
    //                     'gagal' => 'Data hari dan jam tidak tersedia',
    //                 ], 303);
    //             }
    //         }
    //     }

    //     if ($weight == 1) {
    //         $detailLesson = new DetailLesson();
    //         $detailLesson->lesson_hour_id = $id;
    //         $detailLesson->curriculum_id = $curriculum_id;
    //         $detailLesson->day = $day;
    //         $detailLesson->hour = $hour;
    //         $detailLesson->weight = 1;
    //         $detailLesson->save();
    //     } elseif ($weight == 2) {
    //         $detailLesson = new DetailLesson();
    //         $detailLesson->lesson_hour_id = $id;
    //         $detailLesson->curriculum_id = $curriculum_id;
    //         $detailLesson->day = $day1;
    //         $detailLesson->hour = $hour1;
    //         $detailLesson->weight = 1;
    //         $detailLesson->save();

    //         $detailLesson = new DetailLesson();
    //         $detailLesson->lesson_hour_id = $id;
    //         $detailLesson->curriculum_id = $curriculum_id;
    //         $detailLesson->day = $day1;
    //         $detailLesson->hour = $hour2;
    //         $detailLesson->weight = 1;
    //         $detailLesson->save();
    //     } elseif ($weight == 3) {
    //         $detailLesson = new DetailLesson();
    //         $detailLesson->lesson_hour_id = $id;
    //         $detailLesson->curriculum_id = $curriculum_id;
    //         $detailLesson->day = $day;
    //         $detailLesson->hour = $hour;
    //         $detailLesson->weight = 1;
    //         $detailLesson->save();

    //         $detailLesson = new DetailLesson();
    //         $detailLesson->lesson_hour_id = $id;
    //         $detailLesson->curriculum_id = $curriculum_id;
    //         $detailLesson->day = $day1;
    //         $detailLesson->hour = $hour1;
    //         $detailLesson->weight = 1;
    //         $detailLesson->save();

    //         $detailLesson = new DetailLesson();
    //         $detailLesson->lesson_hour_id = $id;
    //         $detailLesson->curriculum_id = $curriculum_id;
    //         $detailLesson->day = $day1;
    //         $detailLesson->hour = $hour2;
    //         $detailLesson->weight = 1;
    //         $detailLesson->save();
    //     } elseif ($weight == 4) {
    //         $detailLesson = new DetailLesson();
    //         $detailLesson->lesson_hour_id = $id;
    //         $detailLesson->curriculum_id = $curriculum_id;
    //         $detailLesson->day = $day1;
    //         $detailLesson->hour = $hour1;
    //         $detailLesson->weight = 1;
    //         $detailLesson->save();

    //         $detailLesson = new DetailLesson();
    //         $detailLesson->lesson_hour_id = $id;
    //         $detailLesson->curriculum_id = $curriculum_id;
    //         $detailLesson->day = $day1;
    //         $detailLesson->hour = $hour2;
    //         $detailLesson->weight = 1;
    //         $detailLesson->save();

    //         $detailLesson = new DetailLesson();
    //         $detailLesson->lesson_hour_id = $id;
    //         $detailLesson->curriculum_id = $curriculum_id;
    //         $detailLesson->day = $day2;
    //         $detailLesson->hour = $hour3;
    //         $detailLesson->weight = 1;
    //         $detailLesson->save();

    //         $detailLesson = new DetailLesson();
    //         $detailLesson->lesson_hour_id = $id;
    //         $detailLesson->curriculum_id = $curriculum_id;
    //         $detailLesson->day = $day2;
    //         $detailLesson->hour = $hour4;
    //         $detailLesson->weight = 1;
    //         $detailLesson->save();
    //     }

    //     $lessonHour = LessonHour::find($id);
    //     $total_details = DB::table('detail_lessons')
    //         ->selectRaw('SUM(weight) as total_weight')
    //         ->selectRaw('(Select SUM(' . $lessonHour->type_curriculum . ') from curriculum_lessons where ' . $lessonHour->type_curriculum . ' is not null) total_lesson')
    //         ->where('lesson_hour_id', $id)
    //         ->get();

    //     foreach ($total_details as $key => $total_detail) {
    //         if ($total_detail->total_weight == $total_detail->total_lesson) {
    //             $lessonHour->status = 1;
    //             $lessonHour->save();
    //         }
    //     }

    //     return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $id])->with([
    //         'message' => 'Data berhasil disimpan',
    //     ], 303);
    // }

    public function edit(LessonHour $lessonHour, DetailLesson $detailLesson)
    {
        $days = DB::table('days')->get();
        $classroom = Classroom::find($lessonHour->class_id);
        $curriculum = CurriculumLesson::find($detailLesson->curriculum_id);
        return view('TataUsaha.LessonHour.DetailLesson.edit', compact('lessonHour', 'detailLesson', 'days', 'classroom', 'curriculum'));
    }

    public function update(Request $request, LessonHour $lessonHour, DetailLesson $detailLesson)
    {
        $validation_rules = [
            'day' => 'required',
            'hour' => 'required',
        ];

        $validator = Validator::make($request->all(), $validation_rules);
        $detailLessons = DetailLesson::all();

        if ($validator->fails()) {
            return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $lessonHour->id])
                ->withErrors($validator)->withInput();
        }
        $day = $request->input('day');
        $hour = $request->input('hour');
        foreach ($detailLessons as $key => $detailLesson) {
            if ($detailLesson->lesson_hour_id == $lessonHour->id && $detailLesson->day == $day && $detailLesson->hour == $hour) {
                return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $lessonHour->id])->with([
                    'gagal' => 'Data hari dan jam tidak tersedia',
                ], 303);
            }
        }

        $detailLesson->day = $day;
        $detailLesson->hour = $hour;
        $detailLesson->save();

        return redirect()->route('lesson_hours.detail_lessons.index', ['lesson_hour' => $lessonHour->id])->with([
            'message' => 'Data berhasil diubah',
        ], 303);
    }
}
