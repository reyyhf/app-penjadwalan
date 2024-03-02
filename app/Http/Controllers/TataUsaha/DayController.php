<?php

namespace App\Http\Controllers\TataUsaha;

use App\Day;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $days = Day::all();

        return view('TataUsaha.day.index', compact('days'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $day = Day::find($id);

        return view('TataUsaha.day.edit', compact('day'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Day $day)
    {

        $validation_rules = [
            'name' => 'required|string|max:100',
            'hour_perday' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) {
            return redirect()->route('days.edit', ['day' => $day])
                ->withErrors($validator)->withInput();
        }

        $day->name = $request->input('name');
        $day->hour_perday = $request->input('hour_perday');
        $day->save();

        return redirect()->route('days.index')->with([
            'message' => 'Data berhasil diubah',
        ], 303);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Day::find($id)->delete();
        return redirect()->route('days.index')->with('message', 'Data berhasil dihapus');
    }
}
