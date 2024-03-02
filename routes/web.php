<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', 'HomeController@index')->name('home');
// Route::post('login', 'HomeController@login')->name('login');

use App\Http\Controllers\Report\RincianBebanMengajar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => false
]);

Route::group(["middleware" => ["auth"]], function() {
    Route::get('/', function () {
        return view('template');
    })->name('home');

    Route::resource('users', UserController::class)->names('users')->except("show");
    Route::resource('teachers', TeacherController::class)->names('teachers')->except(["create","store","edit","update","destroy"]);
    Route::resource('category-lessons', TataUsaha\CategoryLessonController::class)->names('category_lessons')->except('show');
    Route::resource('classrooms', TataUsaha\ClassroomController::class)->names('classrooms')->except('show');
    Route::resource('curriculum-lessons', TataUsaha\CurriculumLessonController::class)->names('curriculum_lessons')->except('show');
    Route::resource('days', TataUsaha\DayController::class)->names('days')->except(['show', 'store', 'create']);
    Route::resource('constraints', TataUsaha\ConstraintController::class)->names('constraints')->except(['show', 'store', 'create', 'edit', 'destroy']);

    Route::resource('lesson-hours', TataUsaha\LessonHourController::class)->names('lesson_hours')->except('show');
    Route::resource('lesson-hours.detail-lessons', TataUsaha\DetailLessonController::class)->names('lesson_hours.detail_lessons')->except('show', 'create');

    Route::get('subject-scheduling', [App\Http\Controllers\TataUsaha\SubjectSchedulingController::class, 'index'])->name('subject-scheduling.index');
    Route::get('tabu-search', [App\Http\Controllers\TataUsaha\SubjectSchedulingController::class, 'indexTabuSearch'])->name('tabu-search.index');
    Route::post('tabu-search', [App\Http\Controllers\TataUsaha\SubjectSchedulingController::class, 'searching'])->name('tabu-search.searching');
    Route::post('tabu-search/saved', [App\Http\Controllers\TataUsaha\SubjectSchedulingController::class, 'savedTS'])->name('tabu-search.saved');

    Route::resource('jadwal-pelajaran', Report\JadwalPelajaran::class)->except(['create', 'store', 'edit', 'update']);
    Route::get('jadwal-pelajaran/{id}/pdf', [App\Http\Controllers\Report\JadwalPelajaran::class, 'index_pdf'])->name('jadwal-pelajaran.index_pdf');
    Route::get('jadwal-pelajaran/{id}/cetak-pdf', [App\Http\Controllers\Report\JadwalPelajaran::class, 'cetak_pdf'])->name('jadwal-pelaran.cetak_pdf');

    Route::get('rincian-beban-mengajar', [RincianBebanMengajar::class, 'index'])->name('rincian-beban-mengajar.index');
    Route::get('rincian-beban-mengajar/cetak-pdf', [RincianBebanMengajar::class, 'cetak_pdf'])->name('rincian-beban-mengajar.cetak-pdf');

});


// Route::get('/home', 'HomeController@index')->name('home');
