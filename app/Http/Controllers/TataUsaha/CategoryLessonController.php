<?php

namespace App\Http\Controllers\TataUsaha;

use App\CategoryLesson;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryLessonController extends Controller
{
    public function index(Request $request)
    {
        $categoryLessons = CategoryLesson::all();

        return view('TataUsaha.CategoryLesson.index', compact('categoryLessons'));
    }

    public function create()
    {
        return view('TataUsaha.CategoryLesson.create');
    }

    public function store(Request $request)
    {
        $validation_rules = ['name' => 'required|string|max:100'];
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) {
            return redirect()->route('category_lessons.create')
                        ->withErrors($validator)->withInput();
        }

        $categoryLesson = new CategoryLesson();
        $categoryLesson->name = $request->input('name');
        $categoryLesson->save();

        return redirect()->route('category_lessons.create')->with([
            'message' => 'Data berhasil disimpan',
        ], 303);
    }

    public function edit(CategoryLesson $categoryLesson)
    {
        return view('TataUsaha.CategoryLesson.edit', compact('categoryLesson'));
    }

    public function update(Request $request, CategoryLesson $categoryLesson)
    {
        $validation_rules = ['name' => 'required|string|max:100'];
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) {
            return redirect()->route('category_lessons.edit', ['category_lesson' => $categoryLesson])
                        ->withErrors($validator)->withInput();
        }

        $categoryLesson->name = $request->input('name');
        $categoryLesson->save();

        return redirect('/category-lessons')->with('message', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        CategoryLesson::find($id)->delete();
        return redirect('/category-lessons')->with('message', 'Data berhasil dihapus');
    }
}
