<?php

namespace App\Http\Controllers\TataUsaha;

use App\Constraint;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConstraintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $constraint = Constraint::first();

        return view('TataUsaha.constraint.index', compact('constraint'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Constraint $constraint)
    {
        $validation_rules = [
            'jam_mengajar_perhari' => 'required|numeric',
            'jam_maks_berurutan' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) {
            return redirect()->route('constraints.index', ['constraint' => $constraint])
                ->withErrors($validator)->withInput();
        }

        $constraint->jam_mengajar_perhari = $request->input('jam_mengajar_perhari');
        $constraint->jam_maks_berurutan = $request->input('jam_maks_berurutan');
        $constraint->save();

        return redirect()->route('constraints.index')->with('message', 'Constraint berhasil diperbarui.');
    }
}
