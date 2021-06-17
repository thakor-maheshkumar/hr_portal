<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;
use App\Topic;
use App\Question;
use App\User;
use Auth;
use DB;

class AnswersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $answers = Answer::all();
        return view('admin.answers', compact('answers'));
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
        
        foreach($request->id as $key=>$id)
        {
            $answer=Answer::find($id);
            $answer->marks=$request->marks[$key];
            $answer->save();
        } 
        return redirect('admin/all_reports/'.$answer->topic_id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $answer = Answer::findOrFail($id);
        $answer->delete();
        return back()->with('deleted', "Student's answer has been deleted");
  
    }
    public function getQuestion($user_id,$topic_id)
    {
       $topic = Topic::findOrFail($topic_id);
       $auth=Auth::user();
      
        $users = DB::select( DB::raw("select * from `answers` inner join `questions` on `answers`.`question_id` = `questions`.`id` 
        where (`answers`.`user_id` = $user_id and `answers`.`topic_id` = $topic_id and `answers`.`user_answer` = 0
        and `answers`.`question_id` not in (select `answers`.`question_id` from `answers` where `answers`.`user_id` = $user_id and `answers`.`topic_id` = $topic_id and `answers`.`user_answer` != '0')
        )GROUP BY `answers`.question_id"));
        return response()->json(["users" => $users, "auth"=>$auth]);
    }
}
