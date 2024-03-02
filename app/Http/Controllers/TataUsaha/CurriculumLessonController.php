<?php

namespace App\Http\Controllers\TataUsaha;

use App\CategoryLesson;
use App\CurriculumLesson;
use App\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CurriculumLessonController extends Controller
{
    public function index(Request $request)
    {
        $curriculumLessons = DB::table('curriculum_lessons')
            ->select('curriculum_lessons.*', 'category_lessons.name as category_name')
            ->leftjoin('category_lessons', 'category_lessons.id', '=', 'curriculum_lessons.category_id')
            ->where('curriculum_lessons.deleted_at', null)->get();
        return view('TataUsaha.CurriculumLesson.Index', compact('curriculumLessons'));
    }

    public function create()
    {
        $categoryLessons = CategoryLesson::all();

        return view('TataUsaha.CurriculumLesson.create', compact('categoryLessons'));
    }

    public function store(Request $request)
    {
        $validation_rules = [
            'name_lesson' => 'required|string|max:100',
            'acronym' => 'required|string|max:50',
            'category_id' => 'required',
            'weight_x' => 'nullable|integer|max:4|min:1',
            'weight_xi' => 'nullable|integer|max:4|min:1',
            'weight_xii' => 'nullable|integer|max:4|min:1',
            'weight_x_ips' => 'nullable|integer|max:4|min:1',
            'weight_xi_ips' => 'nullable|integer|max:4|min:1',
            'weight_xii_ips' => 'nullable|integer|max:4|min:1',
        ];
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) {
            return redirect()->route('curriculum_lessons.create')
                ->withErrors($validator)->withInput();
        }

        $curriculumLesson = new CurriculumLesson();
        $curriculumLesson->name_lesson = $request->input('name_lesson');
        $curriculumLesson->acronym = strtoupper($request->input('acronym'));
        $curriculumLesson->category_id = $request->input('category_id');
        $curriculumLesson->weight_x = $request->input('weight_x');
        $curriculumLesson->weight_xi = $request->input('weight_xi');
        $curriculumLesson->weight_xii = $request->input('weight_xii');
        $curriculumLesson->weight_x_ips = $request->input('weight_x_ips');
        $curriculumLesson->weight_xi_ips = $request->input('weight_xi_ips');
        $curriculumLesson->weight_xii_ips = $request->input('weight_xii_ips');
        $curriculumLesson->save();

        return redirect()->route('curriculum_lessons.create')->with([
            'message' => 'Data berhasil disimpan',
        ], 303);
    }

    public function edit(CurriculumLesson $curriculumLesson)
    {
        $categoryLessons = CategoryLesson::all();
        return view('TataUsaha.CurriculumLesson.edit', compact('curriculumLesson', 'categoryLessons'));
    }

    public function update(Request $request, CurriculumLesson $curriculumLesson)
    {
        $validation_rules = [
            'name_lesson' => 'required|string|max:100',
            'acronym' => 'required|string|max:50',
            'category_id' => 'required',
            'weight_x' => 'nullable|integer|max:4|min:1',
            'weight_xi' => 'nullable|integer|max:4|min:1',
            'weight_xii' => 'nullable|integer|max:4|min:1',
            'weight_x_ips' => 'nullable|integer|max:4|min:1',
            'weight_xi_ips' => 'nullable|integer|max:4|min:1',
            'weight_xii_ips' => 'nullable|integer|max:4|min:1',
        ];
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) {
            return redirect()->route('curriculum_lessons.edit', ['curriculum_lesson' => $curriculumLesson])
                ->withErrors($validator)->withInput();
        }

        $curriculumLesson->name_lesson = $request->input('name_lesson');
        $curriculumLesson->acronym = $request->input('acronym');
        $curriculumLesson->category_id = $request->input('category_id');
        $curriculumLesson->weight_x = $request->input('weight_x');
        $curriculumLesson->weight_xi = $request->input('weight_xi');
        $curriculumLesson->weight_xii = $request->input('weight_xii');
        $curriculumLesson->weight_x_ips = $request->input('weight_x_ips');
        $curriculumLesson->weight_xi_ips = $request->input('weight_xi_ips');
        $curriculumLesson->weight_xii_ips = $request->input('weight_xii_ips');
        $curriculumLesson->save();

        return redirect()->route('curriculum_lessons.index')->with([
            'message' => 'Data berhasil diubah',
        ], 303);
    }

    public function destroy($id)
    {
        CurriculumLesson::find($id)->delete();
        return redirect('/curriculum-lessons')->with('message', 'Data berhasil dihapus');
    }
}
