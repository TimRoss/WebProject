<?php

namespace App\Http\Controllers;

use App\student;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class studentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = \App\student::find($id);
        $user = \App\User::find($id);
        return view('pages/studentInfo', compact('student', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = \App\student::find($id);
        $user = \App\User::find($id);
        return view('pages/editInfo', compact('student', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {

        $this->validate( $request, ['c' => 'required',
            'java' => 'required',
            'python' => 'required',
            'teamStyle' => 'required']);
        $students = \App\student::findOrFail($id);
        $students->update($request->all());

        //student::create($input);

        return redirect('pages/studentInfo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
