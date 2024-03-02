<?php

namespace App\Http\Controllers\Report;

use App\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\TeacherLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RincianBebanMengajar extends Controller
{
    private function initSchedule($days, $teachers)
    {
        $lessonHours = DB::table('lesson_hours')
        ->select('lesson_hours.*', 'classrooms.name as class_name')
        ->leftjoin('classrooms', 'classrooms.id', '=', 'lesson_hours.class_id')
        ->where('lesson_hours.deleted_at', null)
        ->where('lesson_hours.start_period', date('Y'))
        ->orderBy('lesson_hours.id', 'asc')->get();

        $result = [];
        foreach ($teachers as $teacher) {
            $classes = [];
            foreach ($lessonHours as $lessonHour) {
                $schedules = [];
                foreach ($days as $day) {
                    $detailLessons = DB::table('detail_lessons')
                        ->select(
                            'detail_lessons.id',
                            'days.name as day_name',
                            'detail_lessons.hour',
                            'curriculum_lessons.id as curriculum_lesson_id',
                            'curriculum_lessons.employee_id as id_guru',
                            'curriculum_lessons.acronym'
                        )
                        ->leftjoin('days', 'days.id', '=', 'detail_lessons.day')
                        ->leftjoin('curriculum_lessons', 'curriculum_lessons.id', '=', 'detail_lessons.curriculum_id')
                        ->leftjoin('lesson_hours', 'lesson_hours.id', '=', 'detail_lessons.lesson_hour_id')
                        ->where('curriculum_lessons.employee_id', $teacher->id)
                        ->where('lesson_hour_id', $lessonHour->id)
                        ->where('days.name', $day)
                        ->orderBy('detail_lessons.day', 'asc')
                        ->orderBy('detail_lessons.hour', 'asc')->get();

                    if (count($detailLessons)) {
                        $schedules[] = $detailLessons;
                    }

                }

                $classes[] = [
                    'class_name' => $lessonHour->class_name,
                    'detail_lessons' => $schedules
                ];
            }
            $result[] = [
                'teacher_id' => $teacher->id,
                'teacher_name' => $teacher->name,
                'teacher_nik' => $teacher->nik,
                'classes' => $classes
            ];
        }

        return $result;
    }

    public function index()
    {
        $title = "Rincian Beban Mengajar";
        $days = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        $hours = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $teachers = collect(Employee::all())->whereIn('position_id', [3, 4]);
        $schedules = $this->initSchedule($days, $teachers);
        // dd($schedules);
        return view('reports.rincian-beban-mengajar.index', compact('title', 'days', 'hours', 'schedules'));
    }

    public function cetak_pdf()
    {
        $title = "Rincian Beban Mengajar";
        $days = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        $hours = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $teachers = collect(Employee::all())->whereIn('position_id', [3, 4]);
        $schedules = $this->initSchedule($days, $teachers);

        $pdf = PDF::loadview('reports.rincian-beban-mengajar.cetak_pdf', [
            'title' => $title,
            'days' => $days,
            'hours' => $hours,
            'schedules' => $schedules
        ])->setPaper('a4', 'landscape');

        $name_file_pdf = 'laporan-' . Str::slug($title);
        return $pdf->stream($name_file_pdf . '.pdf')
                ->header('Content-Type','application/pdf');
    }
}
