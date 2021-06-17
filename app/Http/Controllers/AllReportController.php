<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Topic;
use App\Answer;
use App\Question;
use App\DescriptiveQuestion;

class AllReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::withCount('descriptive_questions')->QuestionCount()->get();
        $questions = Question::all();
        return view('admin.all_reports.index', compact('topics', 'questions'));
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
        $topic = Topic::findOrFail($id);
        $answers = Answer::where('topic_id', $topic->id)->with('descriptive_question')->orderBy('id')->get();
        //dd($answers);
        $students = User::where('id', '!=', Auth::id())->get();

        $c_que = Question::where('topic_id', $id)->count();

        $getofptional=Answer::where('topic_id',$id)->get();

        $sumofoptionalmakrs=$getofptional->sum('marks');

        $d_question=DescriptiveQuestion::where('topic_id',$id)->get();
        
        $sumTotalMarks=DescriptiveQuestion::where('topic_id',$id)->sum('marks');

        $filtStudents = collect();
        //dd($filtStudents);
        foreach ($students as $student) {
            $objAns = [];
            $marks = 0;
          foreach ($answers as $answer) {
            if ($answer->user_id == $student->id) {
                $objAns[] = $answer;
                $marks += $answer->marks;
                $student->answers = (object)$objAns;
                $student->total_marks = $marks;
              $filtStudents->push($student);
            }
          }
        }
        foreach ($students as $student) {
            $objAns = [];
            $marks = 0;
          foreach ($answers as $answer) {
            if ($answer->user_id == $student->id) {
                $objAns[] = $answer;
                $marks += $answer->marks;
                $student->answers = (object)$objAns;
                $student->total_optional_marks = $marks;
              $filtStudents->push($student);
            }
          }
        }
        $filtStudents = $filtStudents->unique();
        $filtStudents = $filtStudents->flatten();
       
        return view('admin.all_reports.show', compact('filtStudents', 'answers', 'c_que', 'topic','d_question','sumTotalMarks','sumObtainMarks','sumofoptionalmakrs'));
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
    public function delete($topicid,$userid)
    {   
         $topicid.$userid;
         $answer = Answer::where('user_id',$userid)->where('topic_id',$topicid)->delete();
         return back()->with('deleted','Response Reset Successfully !');
    }
    
    public function answershow($student_id,$topic_id){
        $topic = Topic::findOrFail($topic_id);
        $answers = Answer::where('topic_id', $topic->id)->where('user_id',$student_id)->with('descriptive_question')->orderBy('id')->get();

        return view('answershow', compact('answers'));
    }
    public function optionalmarksshow($student_id,$topic_id)
    {           
        $topic = Topic::findOrFail($topic_id);
        $answers=Answer::where('topic_id',$topic->id)->where('user_id',$student_id)->get();
        $answerss=$answers->sum('marks');
        return view('optionalshow',compact('answerss'));
    }    
    }  
