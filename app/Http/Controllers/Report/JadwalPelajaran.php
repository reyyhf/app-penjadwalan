<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\TabuSearchReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class JadwalPelajaran extends Controller
{
    public function index()
    {

        $reports = TabuSearchReport::all();

        return view('reports.jadwal_pelajaran.index', compact('reports'));
    }

    public function show($id)
    {
        $days = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        $hours = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $ts_report = TabuSearchReport::with(['class_reports' => function ($query) {
            $query->with(['schedule_reports' => function ($query) {
                $query->with(['hour_reports']);
            }]);
        }])->find($id);

        $class_reports = $ts_report->class_reports;
        $score = $this->countedScoreConflict($class_reports);

        return view('reports.jadwal_pelajaran.detail', compact([
            'days',
            'hours',
            'ts_report',
            'class_reports',
            'score'
        ]));
    }

    public function destroy($id)
    {
        try {
            $ts_report = TabuSearchReport::find($id);
            $ts_report->delete();

            return redirect()->back()->with('message', 'Data berhasil dihapus!');
        } catch (Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function index_pdf($id)
    {
        $days = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        $hours = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $ts_report = TabuSearchReport::with(['class_reports' => function ($query) {
            $query->with(['schedule_reports' => function ($query) {
                $query->with(['hour_reports']);
            }]);
        }])->find($id);

        $class_reports = $ts_report->class_reports;
        $score = $this->countedScoreConflict($class_reports);

        return view('reports.jadwal_pelajaran.index_pdf', compact([
            'days',
            'hours',
            'ts_report',
            'class_reports',
            'score'
        ]));
    }

    public function cetak_pdf($id)
    {
        $days = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        $hours = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $ts_report = TabuSearchReport::with(['class_reports' => function ($query) {
            $query->with(['schedule_reports' => function ($query) {
                $query->with(['hour_reports']);
            }]);
        }])->find($id);

        $class_reports = $ts_report->class_reports;
        $score = $this->countedScoreConflict($class_reports);

        $pdf = PDF::loadview('reports.jadwal_pelajaran.cetak_pdf', [
            'days' => $days,
            'hours' => $hours,
            'ts_report' => $ts_report,
            'class_reports' => $class_reports,
            'score' => $score
        ])->setPaper('a4', 'landscape');

        $name_file_pdf = 'laporan-' . Str::slug($ts_report->title);
        return $pdf->stream($name_file_pdf . '.pdf')
                ->header('Content-Type','application/pdf');
    }


    // private function
    private function countedScoreConflict($schedule)
    {
        $conflict_score = 0;
        foreach ($schedule as $value1) {
            foreach ($value1->schedule_reports as $value2) {
                foreach ($value2->hour_reports as $value3) {
                    if (isset($value3->conflict)) {
                        $conflict_score += $value3->conflict;
                    }
                }
            }
        }

        return $conflict_score;
    }
}
