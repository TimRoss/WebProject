<?php

namespace App\Http\Controllers;

use App\student;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
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

        $team = DB::table('students')
            ->join('teamMembers', 'students.id', '=', 'teamMembers.studentId')
            ->join('teams', 'teamMembers.teamId', '=', 'teams.id')
            ->select('teams.name')
            ->where('students.id', '=', $id)
            ->get();
        return view('pages/studentInfo', compact('student', 'user', 'team'));
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
        if(auth()->user()->id == $id) {
            return view('pages/editInfo', compact('student', 'user'));
        }
        else{
            return redirect('/home');
        }
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

        return redirect('/home');
    }

    public function assignTeam( Request $request){

        $table = DB::update('update teamMembers set teamId = ? where studentId = ?', [$request->teamId, $request->id]);

        return back();
    }

    public function removeMember( Request $request){


        $table = DB::update('update teamMembers set teamId = ? where studentId = ?', [0, $request->id]);

        return back();
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

    public function team()
    {
        $this->recalcTeamLanguages();
        $teams = \App\team::all();
        $members = DB::table('teams')
            ->join('teamMembers', 'teams.id', '=', 'teamMembers.teamId')
            ->join('users', 'teamMembers.studentId', '=', 'users.id')
            ->select('teams.id', 'users.name', 'teamMembers.studentId')
            ->get();

        return view('pages/teamInfo', compact('teams', 'members'));
    }

    public function admin()
    {
        $this->recalcTeamLanguages();
        $teams = \App\team::all();
        $members = DB::table('teams')
            ->join('teamMembers', 'teams.id', '=', 'teamMembers.teamId')
            ->join('users', 'teamMembers.studentId', '=', 'users.id')
            ->select('teams.id', 'users.name', 'teamMembers.studentId')
            ->get();
        $leftovers = DB::table('teamMembers')
            ->join('students', 'students.id', '=', 'teamMembers.studentId')
            ->join('users', 'teamMembers.studentId', '=', 'users.id')
            ->select('users.name', 'users.id', 'students.c', 'students.java', 'students.python')
            ->where('teamMembers.teamId', '=', '0')
            ->get();
        return view('admin/teamInfo', compact('teams', 'members', 'leftovers'));
    }



    public function makeTeams(Request $request)
    {
        //delete all from teams and teamMembers
        DB::table('teams')->truncate();
        DB::table('teamMembers')->truncate();
        //put all students into array
        $students = \App\student::all();
        $comp = array();
        $sosh = array();
        $donkeyKong = array();



        foreach($students as $student) {
            $student->skill = 4 * $student->fourHundreds + 3 * $student->threeHundreds + 2 * $student->twoHundreds;


            if ($student->teamStyle == "competitive") {
                array_push($comp, $student);
            } elseif ($student->teamStyle == "social") {
                array_push($sosh, $student);
            } else {
                array_push($donkeyKong, $student);
            }
        }
        $id = 1;
        //sort arrays by skill
        $comp = collect($comp)->sortBy('skill');
        $sosh = collect($sosh)->sortBy('skill');
        $donkeyKong = collect($donkeyKong)->sortBy('skill');

        $teams = $this->algorithm($comp, intval($request->max), intval($request->min));

        for($i = 1; $i < count($teams); $i = $i + 1){
            $c = 0;
            $j = 0;
            $p = 0;
            foreach($teams[$i] as $student){
                $c = $c + intval($student->c);
                $j = $j + intval($student->java);
                $p = $p + intval($student->python);
            }

            DB::table('teams')->insert(
                array('name' => "Team " . $id,'c' => $c, 'java' => $j, 'python' => $p, 'type' => 'Competitive')
            );
            foreach($teams[$i] as $student){
                DB::table('teamMembers')->insert(
                    array('studentId' => $student->id, 'teamId' => $id)
                );
            }
            $id = $id + 1;
        }
        foreach($teams[0] as $student){
            DB::table('teamMembers')->insert(
                array('studentId' => $student->id, 'teamId' => 0)
            );
        }


        $teams = $this->algorithm($sosh, $request->max, $request->min);
        for($i = 1; $i < count($teams); $i = $i + 1){
            $c = 0;
            $j = 0;
            $p = 0;
            foreach($teams[$i] as $student){
                $c = $c + intval($student->c);
                $j = $j + intval($student->java);
                $p = $p + intval($student->python);
            }

            DB::table('teams')->insert(
                array('name' => "Team " . $id,'c' => $c, 'java' => $j, 'python' => $p, 'type' => 'Social')
            );
            foreach($teams[$i] as $student){
                DB::table('teamMembers')->insert(
                    array('studentId' => $student->id, 'teamId' => $id)
                );
            }
            $id = $id + 1;
        }
        foreach($teams[0] as $student){
            DB::table('teamMembers')->insert(
                array('studentId' => $student->id, 'teamId' => 0)
            );
        }


        $teams = $this->algorithm($donkeyKong,$request->max, $request->min);
        for($i = 1; $i < count($teams); $i = $i + 1){
            $c = 0;
            $j = 0;
            $p = 0;
            foreach($teams[$i] as $student){
                $c = $c + intval($student->c);
                $j = $j + intval($student->java);
                $p = $p + intval($student->python);
            }

            DB::table('teams')->insert(
                array('name' => "Team " . $id,'c' => $c, 'java' => $j, 'python' => $p, 'type' => "Don't Care")
            );
            foreach($teams[$i] as $student){
                DB::table('teamMembers')->insert(
                    array('studentId' => $student->id, 'teamId' => $id)
                );
            }
            $id = $id + 1;
        }
        foreach($teams[0] as $student){
            DB::table('teamMembers')->insert(
                array('studentId' => $student->id, 'teamId' => 0)
            );
        }


        return Redirect::back();
    }

    public function algorithm(Collection $students, $max, $min)
    {
        $numTeams = floor(count($students) / $min);

        $teams = array();
        $teams[0] = array();
        for($i = 0; $i < $numTeams; $i++){
            $teams[$i + 1] = array();
            for($j = 0; $j < $min; $j++){
                array_push($teams[$i + 1],$students->pop());
            }
        }
        $teamCount = 0;
        while(count($students) > 0){
            if(count($teams[$teamCount]) == $max){
                break;
            }
            array_push($teams[$teamCount],$students->pop());
            $teamCount = $teamCount + 1;
            if($teamCount >= $numTeams){
                $teamCount = 0;
            }
        }
        if(count($students) > 0){
            foreach($students as $student){
                push_array($teams[0], $student);
            }
        }
        return $teams;
        //seperate by skill
        /*
        $languages = array();
        $scores = array();
        $leftovers = array();

        for( $i = 0; $i < $min; $i = $i + 1){
            $scores[$i] = $students->splice(0, count($students)/ ($min - $i));
            $languages[$i] = array();
        }
        for($i = 0; $i < count($scores); $i = $i + 1) {
            $languages[$i][0] = array(); //c
            $languages[$i][1] = array(); //java
            $languages[$i][2] = array(); //python
            foreach($scores[$i] as $student){
                if($student->c >= $student->java && $student->c >= $student->python)
                {
                    if($student->java >= $student->python)
                    {
                        $student->diff = $student->c - $student->java;
                    }
                    else
                    {
                        $student->diff = $student->c - $student->python;
                    }
                    array_push($languages[$i][0],$student);
                }
                elseif($student->java >= $student->python){
                    if($student->c >= $student->python)
                    {
                        $student->diff = $student->java - $student->c;
                    }
                    else
                    {
                        $student->diff = $student->java - $student->python;
                    }
                    array_push($languages[$i][1], $student);
                }
                else{
                    if($student->c >= $student->java)
                    {
                        $student->diff = $student->python - $student->c;
                    }
                    else
                    {
                        $student->diff = $student->python - $student->java;
                    }
                    array_push($languages[$i][2], $student);
                }
            }
        }

        for($i = 0; $i < 2; $i = $i + 1) {
            while ($this->checkTeam($languages, $i)) {
                array_push($teams, $this->makeTeam($languages, $i));
            }
//            if($i == 2){
//                //this if statements fixes it for some reason
//            }
        }
       // dd("3");
        for($i = 0; $i < count($languages); $i = $i + 1){
            for($j = 0; $j < count($languages[$i]); $j = $j + 1){
                for($k = 0; $k < count($languages[$i][$j]); $k = $k + 1){

                    if($j = 0) {
                        dd($i, $j, $k);
                        if ($languages[$i][$j][$k]->c - $languages[$i][$j][$k]->diff == $languages[$i][$j][$k]->java) {

                            array_push($languages[$i][1], $languages[$i][$j][$k]);
                            if ($this->checkTeam($languages, 1)) {
                                array_push($teams, $this->makeTeam($languages, 1));
                                unset($languages[$i][$j][$k]);
                            } else {
                                unset($languages[$i][1][count($languages[$i][1])]);
                            }
                        } else {
                            array_push($languages[$i][2], $languages[$i][$j][$k]);
                            if ($this->checkTeam($languages, 2)) {
                                array_push($teams, $this->makeTeam($languages, 2));
                                unset($languages[$i][$j][$k]);
                            } else {
                                unset($languages[$i][2][count($languages[$i][2])]);
                            }
                        }
                    }
                    elseif($j=1){

                        if ($languages[$i][$j][$k]->java - $languages[$i][$j][$k]->diff == $languages[$i][$j][$k]->c) {

                            array_push($languages[$i][0], $languages[$i][$j][$k]);
                            if ($this->checkTeam($languages, 0)) {
                                array_push($teams, $this->makeTeam($languages, 0));
                                unset($languages[$i][$j][$k]);
                            } else {
                                unset($languages[$i][0][count($languages[$i][0])]);
                            }
                        } else {
                            array_push($languages[$i][2], $languages[$i][$j][$k]);
                            if ($this->checkTeam($languages, 2)) {
                                array_push($teams, $this->makeTeam($languages, 2));
                                unset($languages[$i][$j][$k]);
                            } else {
                                unset($languages[$i][2][count($languages[$i][2])]);
                            }
                        }

                    }
                    else{
                        dd($i, $j, $k);
                        if ($languages[$i][$j][$k]->python - $languages[$i][$j][$k]->diff == $languages[$i][$j][$k]->java) {
                            array_push($languages[$i][1], $languages[$i][$j][$k]);
                            if ($this->checkTeam($languages, 1)) {
                                array_push($teams, $this->makeTeam($languages, 1));
                                unset($languages[$i][$j][$k]);
                            } else {
                                unset($languages[$i][1][count($languages[$i][1])]);
                            }
                        } else {
                            array_push($languages[$i][0], $languages[$i][$j][$k]);
                            if ($this->checkTeam($languages, 0)) {
                                array_push($teams, $this->makeTeam($languages, 0));
                                unset($languages[$i][$j][$k]);
                            } else {
                                unset($languages[$i][0][count($languages[$i][0])]);
                            }
                        }
                    }
                }
            }
        }
        dd('4');
        //put any reamaining students into single leftovers array
        for($i = 0; $i < count($languages); $i = $i + 1) {
            for ($j = 0; $j < count($languages[$i]); $j = $j + 1) {
                for ($k = 0; $k < count($languages[$i][$j]); $k = $k + 1) {
                    array_push($leftovers, $languages[$i][$j][$k]);
                }
            }
        }


        //make as many teams from the leftovers as possible
        while(count($leftovers) > $min){
            array_push($teams, $leftovers->splice(0, $min));
        }

        //try to put remaining leftovers into teams
        while(count($teams[1]) < $max) {
            for ($i = 1; $i < count($teams); $i = $i + 1) {
                array_push($teams[$i], $leftovers->splice(0,1));
            }
        }

        return $teams;
        */
    }

    public function checkTeam($languages, $j){
        for($i = 0; $i < count($languages); $i = $i + 1){
            if(count($languages[$i][$j]) == 0){
                return false;
            }
        }
        return true;
    }

    public function makeTeam($languages, $j){
        $team = array();
        for($i = 0; $i < count($languages); $i = $i + 1){
            $offset = 0;
            $gDiff = 0;
            for($k = 0; $k < count($languages[$i][$j]); $k = $k + 1){
                if($languages[$i][$j][$k]->diff > $gDiff){
                    $gDiff = $languages[$i][$j][$k]->diff;
                    $offset = $k;
                }
            }
            array_push($team, $languages[$i][$j][$offset]);
            unset($languages[$i][$j][$offset]);
            array_values($languages[$i][$j]);
        }
        return $team;
    }

    public function recalcTeamLanguages(){
        $teams = DB::select('select id from teams');
        foreach($teams as $team) {
            $c = 0;
            $java = 0;
            $python = 0;

            $students = DB::table('students')
                ->join('teamMembers', 'students.id', '=', 'teamMembers.studentId')
                ->select('students.c', 'students.java', 'students.python')
                ->where('teamMembers.teamId', '=', $team->id)
                ->get();

            foreach($students as $student){
                $c = $c + $student->c;
                $java = $java + $student->java;
                $python = $python + $student->python;

            }
            DB::update('update teams set c=?, java=?, python=? where id=?', array($c, $java, $python, $team->id));

        }
    }

}
