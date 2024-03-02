<?php

namespace App\Http\Controllers\TataUsaha;

use App\ClassReport;
use App\Constraint;
use App\Day;
use App\HourReport;
use App\Http\Controllers\Controller;
use App\ScheduleReport;
use App\TabuSearchReport;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubjectSchedulingController extends Controller
{
    private function my_array_unique($array, $keep_key_assoc = false)
    {
        $duplicate_keys = array();
        $tmp = array();

        foreach ($array as $key => $val) {
            // convert objects to arrays, in_array() does not support objects
            if (is_object($val))
                $val = (array)$val;

            $filter = array_filter($tmp, function ($item) use ($val) {
                return $item['acronym'] == $val['acronym'];
            });

            if (count($filter) == 0)
                $tmp[] = $val;
            else
                $duplicate_keys[] = $key;
        }

        foreach ($duplicate_keys as $key)
            unset($array[$key]);

        return $array;
        // return $keep_key_assoc ? $array : array_values($array);
    }

    private function my_usort($unDuplicatedSchedules, $schedules)
    {
        $result = collect([]);

        foreach ($unDuplicatedSchedules as $value) {
            $temp = $schedules->filter(function ($obj) use ($value) {
                return strtoupper($obj->acronym) == strtoupper($value->acronym);
            });

            foreach ($temp as $temp_value) {
                $result[] = $temp_value;
            }
        }

        return $result;
    }

    private function deepClone($object)
    {
        return unserialize(serialize($object));
    }

    private function initSchedule($days)
    {
        $lessons = [];
        $lessonHours = DB::table('lesson_hours')
            ->select('lesson_hours.*', 'classrooms.name as class_name')
            ->leftjoin('classrooms', 'classrooms.id', '=', 'lesson_hours.class_id')
            ->where('lesson_hours.deleted_at', null)
            ->where('lesson_hours.start_period', date('Y'))
            ->orderBy('lesson_hours.id', 'asc')->get();

        foreach ($lessonHours as $key => $value) {
            $schedules = [];
            foreach ($days as $day) {
                $detailLessons = DB::table('detail_lessons')
                    ->select('detail_lessons.id', 'days.name as day_name', 'detail_lessons.employee_id as id_guru', 'curriculum_lessons.id as curriculum_lesson_id', 'curriculum_lessons.acronym')
                    ->leftjoin('days', 'days.id', '=', 'detail_lessons.day')
                    ->leftjoin('curriculum_lessons', 'curriculum_lessons.id', '=', 'detail_lessons.curriculum_id')
                    ->leftjoin('lesson_hours', 'lesson_hours.id', '=', 'detail_lessons.lesson_hour_id')
                    ->where('lesson_hour_id', $value->id)
                    ->where('days.name', $day->name)
                    ->orderBy('detail_lessons.day', 'asc')
                    ->orderBy('detail_lessons.hour', 'asc')->get();

                if (count($detailLessons)) {
                    $schedules[] = [
                        'day' => $detailLessons[0]->day_name,
                        'hours' => $detailLessons
                    ];
                }
            }

            $lessons[] = [
                'class_name' => $value->class_name,
                'schedule' => $schedules
            ];
        }

        // data manual
        // $lessons = [
        //     [
        //         "class_name" => "IPS 1",
        //         "schedule" => [
        //             [
        //                 "day" => "Senin",
        //                 "hours" => json_decode('[
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 5,
        //                         "acronym": "BING",
        //                         "id_guru": 13
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 8,
        //                         "acronym": "PAI",
        //                         "id_guru": 21
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 1,
        //                         "acronym": "MAT",
        //                         "id_guru": 11
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 6,
        //                         "acronym": "OLGA",
        //                         "id_guru": 20
        //                     }
        //                 ]'),
        //             ],
        //             [
        //                 "day" => "Selasa",
        //                 "hours" => json_decode('[
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 2,
        //                         "acronym": "BIND",
        //                         "id_guru": 10
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 2,
        //                         "acronym": "BIND",
        //                         "id_guru": 10
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 5,
        //                         "acronym": "BING",
        //                         "id_guru": 13
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 5,
        //                         "acronym": "BING",
        //                         "id_guru": 13
        //                     }
        //                 ]'),
        //             ],
        //             [
        //                 "day" => "Jumat",
        //                 "hours" => json_decode('[
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 2,
        //                         "acronym": "BIND",
        //                         "id_guru": 10
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 2,
        //                         "acronym": "BIND",
        //                         "id_guru": 10
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 5,
        //                         "acronym": "BING",
        //                         "id_guru": 13
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 5,
        //                         "acronym": "BING",
        //                         "id_guru": 13
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 7,
        //                         "acronym": "PROD",
        //                         "id_guru": 15
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 7,
        //                         "acronym": "PROD",
        //                         "id_guru": 15
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 1,
        //                         "acronym": "MAT",
        //                         "id_guru": 11
        //                     }
        //                 ]'),
        //             ],
        //         ]
        //     ],
        //     [
        //         "class_name" => "IPS 2",
        //         "schedule" => [
        //             [
        //                 "day" => "Senin",
        //                 "hours" => json_decode('[
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 1,
        //                         "acronym": "MAT",
        //                         "id_guru": 11
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 1,
        //                         "acronym": "MAT",
        //                         "id_guru": 11
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 1,
        //                         "acronym": "MAT",
        //                         "id_guru": 99
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 1,
        //                         "acronym": "MAT",
        //                         "id_guru": 12
        //                     }
        //                 ]'),
        //             ],
        //             [
        //                 "day" => "Selasa",
        //                 "hours" => json_decode('[
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 6,
        //                         "acronym": "OLGA",
        //                         "id_guru": 20
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 6,
        //                         "acronym": "OLGA",
        //                         "id_guru": 20
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 6,
        //                         "acronym": "OLGA",
        //                         "id_guru": 20
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 8,
        //                         "acronym": "PAI",
        //                         "id_guru": 21
        //                     },
        //                     {
        //                         "id": 10,
        //                         "curriculum_lesson_id": 8,
        //                         "acronym": "PAI",
        //                         "id_guru": 21
        //                     }
        //                 ]'),
        //             ],
        //         ]
        //     ],
        // ];

        // dd($lessons, $lessonss);

        return $lessons;
    }

    private function evaluateSchedule($lessons, $days)
    {
        $schedule = $lessons;
        $constraint = Constraint::first();

        // cek jadwal yang betrok
        for ($i = 0; $i < count($schedule); $i++) {
            for ($j = $i + 1; $j < count($schedule); $j++) {
                foreach ($days as $day) {
                    $schedule_filter_i = array_filter($schedule[$i]['schedule'], function ($k) use ($day) {
                        return strtolower($k['day']) == strtolower($day->name);
                    });

                    $schedule_filter_j = array_filter($schedule[$j]['schedule'], function ($k) use ($day) {
                        return strtolower($k['day']) == strtolower($day->name);
                    });

                    for ($key = 0; $key < $day->hour_perday; $key++) {
                        $key_first_sfi = array_key_first($schedule_filter_i);
                        $key_first_sfj = array_key_first($schedule_filter_j);

                        if (isset($schedule_filter_i[$key_first_sfi]['hours'][$key]) && isset($schedule_filter_j[$key_first_sfj]['hours'][$key])) {
                            $data_i = $schedule_filter_i[$key_first_sfi]['hours'][$key];
                            $data_j = $schedule_filter_j[$key_first_sfj]['hours'][$key];

                            // guru tidak boleh mengajar lebih dari satu kelas atau mengajar di kelas lain pada waktu yang sama
                            if ($data_i->id_guru == $data_j->id_guru) {
                                $schedule[$i]['schedule'][key($schedule_filter_i)]['hours'][$key]->{'conflict'} = 20;
                                $schedule[$j]['schedule'][key($schedule_filter_j)]['hours'][$key]->{'conflict'} = 20;
                            }
                        }
                    }
                }
            }
        }

        foreach ($schedule as $key_schedule => $value1) {
            foreach ($days as $day) {
                $filter_days = array_filter($value1['schedule'], function ($k) use ($day) {
                    return strtolower($k['day']) == strtolower($day->name);
                });

                foreach ($filter_days as $key_filter_day => $filter_day) {
                    foreach ($filter_day['hours'] as $key_filter_hour => $filter_day_hour) {
                        $curriculum_lesson_id = $filter_day_hour->curriculum_lesson_id;
                        $id_guru = $filter_day_hour->id_guru;

                        // guru tidak boleh mengajar melebihi 2 jam perhari dalam 1 matkul di kelas yang sama
                        $filter_hours = $filter_day['hours']->filter(function ($k) use ($curriculum_lesson_id, $id_guru) {
                            return ($k->curriculum_lesson_id == $curriculum_lesson_id) && ($k->id_guru == $id_guru);
                        });

                        // Room! Jam Mengajar Perhari dan permatkul di kelas yang sama
                        if (count($filter_hours) > $constraint->jam_mengajar_perhari) {
                            $schedule[$key_schedule]['schedule'][$key_filter_day]['hours'][$key_filter_hour]->{'conflict'} = 20;
                        };
                    }
                }
            }
        }

        // jam maksimal matpel berurutan adalah 2 jam perhari
        foreach ($schedule as $key => $s) {
            foreach ($s['schedule'] as $key2 => $s2) {
                $filtered_hours_duplicated = $s2['hours']->filter(function ($item) {
                    static $counts = array();
                    if (isset($counts[$item->curriculum_lesson_id])) {
                        return false;
                    }

                    $counts[$item->curriculum_lesson_id] = true;
                    return true;
                });

                foreach ($filtered_hours_duplicated as $h) {
                    $filter_hours = $s2['hours']->filter(function ($k) use ($h) {
                        return $k->curriculum_lesson_id == $h->curriculum_lesson_id;
                    });

                    // Room! Jam maks matpel berurutan perhari
                    if (count($filter_hours) > $constraint->jam_maks_berurutan) {
                        foreach ($filter_hours as $key_cons => $value) {
                            $schedule[$key]['schedule'][$key2]['hours'][$key_cons]->{'conflict'} = 20;
                        }
                    };
                }
            }
        }

        // maksimal kegiatan belajar mengajar adalah 10 jam perhari, khusus hari jumat 6 jam perhari
        foreach ($schedule as $key1 => $value1) {
            foreach ($days as $key => $day) {
                $filter_perhari = array_filter($value1['schedule'], function ($item) use ($day) {
                    return strtolower($item['day']) == strtolower($day->name);
                });

                $index_schedule = array_key_first($filter_perhari);

                // Room! constraint hari jumat
                if ($index_schedule != "" && count($filter_perhari[$index_schedule]['hours']) > $day->hour_perday) {
                    for ($a = $day->hour_perday; $a < count($filter_perhari[$index_schedule]['hours']); $a++) {
                        $schedule[$key1]['schedule'][$index_schedule]['hours'][$a]->{'conflict'} = 20;
                    }
                }
            }
        }

        return $schedule;
    }

    private function countedScoreConflict($schedule)
    {
        $conflict_score = 0;
        foreach ($schedule as $value1) {
            foreach ($value1['schedule'] as $value2) {
                foreach ($value2['hours'] as $value3) {
                    if (isset($value3->conflict)) {
                        $conflict_score += $value3->conflict;
                    }
                }
            }
        }

        return $conflict_score;
    }

    private function generateNewSolution($currentSchedule, $days)
    {
        $scheduleRand = [];
        foreach ($currentSchedule as $value) {
            foreach ($value['schedule'] as $value2) {
                foreach ($value2['hours'] as $hour) {
                    unset($hour->conflict);
                    $scheduleRand[] = $hour;
                }
            }
        }

        $newSchedule = $currentSchedule;

        // tukar bentrokkan
        foreach ($newSchedule as $key1 => $value) {
            foreach ($value['schedule'] as $key2 => $value2) {
                foreach ($value2['hours'] as $key3 => $hour) {
                    // if (isset($hour->conflict) && $hour->conflict) {
                    $index_rand = array_rand($scheduleRand);
                    $newSchedule[$key1]['schedule'][$key2]['hours'][$key3] = $scheduleRand[$index_rand];
                    // }
                    unset($scheduleRand[$index_rand]);
                }
            }
        }

        // hapus jadwal hari yang melebihi jam yang sudah ditentukan
        foreach ($newSchedule as $key1 => $value1) {
            foreach ($days as $day) {
                $filter_hari_jumat = array_filter($value1['schedule'], function ($k) use($day) {
                    return strtolower($k['day']) == strtolower($day->name);
                });
                $index_first = array_key_first($filter_hari_jumat);

                if ($index_first != "") {
                    $filter_hours = $filter_hari_jumat[$index_first]['hours'];
                    if (count($filter_hours) > $day->hour_perday) {
                        for ($i = $day->hour_perday; $i < count($filter_hours); $i++) {
                            unset($newSchedule[$key1]['schedule'][$index_first]['hours'][$i]);
                        }
                    }
                }
            }
        }

        // sorting schedules
        foreach ($newSchedule as $key_value1 => $value1) {
            foreach ($value1['schedule'] as $key_schedule => $schedule) {
                $duplicated = $this->my_array_unique($this->deepClone($schedule['hours']));
                $result = $this->my_usort($duplicated, $schedule['hours']);
                $newSchedule[$key_value1]['schedule'][$key_schedule]['hours'] = $result;
            }
        }

        return $newSchedule;
    }

    private function tabuSearch($initSchedule, $tabuSize, $maxIteration, $days)
    {
        $currentSolution = $this->deepClone($initSchedule);
        $bestSolution = $this->deepClone($initSchedule);
        $bestScore = $this->countedScoreConflict($bestSolution);
        $tabuList = [];

        for ($iteration = 0; $iteration < $maxIteration; $iteration++) {
            $newSolution = $this->generateNewSolution($currentSolution, $days);

            $newEvaluateSchedule = $this->evaluateSchedule($newSolution, $days);


            $newScore = $this->countedScoreConflict($newEvaluateSchedule);
            if ($newScore < $bestScore) {
                $bestSolution = $this->deepClone($newSolution);
                $bestScore = $newScore;
            }

            if (!in_array($newSolution, $tabuList)) {
                $tabuList[] = $this->deepClone($newSolution);

                if (count($tabuList) > $tabuSize) {
                    array_shift($tabuList);
                }

                $currentSolution = $this->deepClone($newSolution);
            }
        }

        return [
            'bestSolution' => $bestSolution,
            'bestScore' => $bestScore,
        ];
    }


    public function index()
    {
        // $days = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        // $hours = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $days = Day::all();
        $lessons = $this->initSchedule($days);
        $lessons = $this->evaluateSchedule($lessons, $days);
        $conflict_score = $this->countedScoreConflict($lessons);

        return view(
            'TataUsaha.SubjectScheduling.index',
            compact('days', 'lessons', 'conflict_score')
        );
    }

    public function indexTabuSearch()
    {
        return view('TataUsaha.TabuSearch.index');
    }

    public function searching(Request $request)
    {
        $validation_rules = [
            'tabu_size' => 'required|numeric|min:1',
            'max_iteration' => 'required|numeric|min:1',
        ];

        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)->withInput();
        }

        // $days = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        // $hours = ['1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $days = Day::all();
        $lessons = $this->initSchedule($days);
        $evaluate = $this->evaluateSchedule($lessons, $days);
        $lessons = $this->deepClone($evaluate);

        $tabuSize = $request->input('tabu_size');
        $maxIteration = $request->input('max_iteration');

        $result = $this->tabuSearch($lessons, $tabuSize, $maxIteration, $days);
        $bestSolution = $result['bestSolution'];
        $bestScore = $result['bestScore'];

        return view('TataUsaha.TabuSearch.result', compact('bestSolution', 'bestScore', 'days'));
    }

    public function savedTS(Request $request)
    {
        $bestSolution = $request->input('best_solution');
        $obj = json_decode($bestSolution);

        try {
            $max_ts_report = TabuSearchReport::max('id');
            $max_ts_report = (int) $max_ts_report + 1;

            $ts_report = TabuSearchReport::create([
                'title' => "Report TS-" . $max_ts_report
            ]);

            if ($ts_report) {
                foreach ($obj as $val1) {
                    $class_report = ClassReport::create([
                        'ts_report_id' => $ts_report->id,
                        'class_name' => $val1->class_name
                    ]);

                    if ($class_report) {
                        foreach ($val1->schedule as $schedule) {
                            $schedule_report = ScheduleReport::create([
                                'class_report_id' => $class_report->id,
                                'day' => $schedule->day
                            ]);

                            if ($schedule_report) {
                                foreach ($schedule->hours as $hour) {
                                    $conflict = isset($hour->conflict) ? $hour->conflict : 0;

                                    HourReport::create([
                                        'schedule_report_id' => $schedule_report->id,
                                        'day_name' => $hour->day_name,
                                        'curriculum_lesson_id' => $hour->curriculum_lesson_id,
                                        'id_guru' => $hour->id_guru,
                                        'acronym' => $hour->acronym,
                                        'conflict' => $conflict
                                    ]);
                                }
                            }
                        }
                    }
                } // end $obj foreach
            }

            return redirect()->route('tabu-search.index')->with('message', 'Data hasil tabu search berhasil disimpan!');
        } catch (Exception $e) {
            return redirect()->route('tabu-search.index')->with('message', $e->getMessage());
        }
    }
}
