<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use App\Question;
use App\DescriptiveQuestion;
use App\OptionalMultiple;
class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::where('test_type','=','0')->get();

        $questions = Question::all();
        return view('admin.questions.index', compact('questions', 'topics'));
    }

    public function descriptiveScoring(Request $request)
    {

        $topics = Topic::where('test_type','=','1')->withCount('descriptive_questions')->QuestionCount()->get();
        
        $questions = DescriptiveQuestion::all();
       //dd($topics);
        return view('admin.questions.descriptive', compact('questions', 'topics'));
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
     * Import a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function importExcelToDB(Request $request)
    {
      $request->validate([
        'question_file' => 'required|mimes:xlsx'
      ]);
      if($request->hasFile('question_file')){
          $path = $request->file('question_file')->getRealPath();
          $data = \Excel::load($path)->get();
          if($data->count()){
              foreach ($data as $key => $value) {
                  $arr[] = ['topic_id' => $request->topic_id, 'question' => $value->question, 'a' => $value->a, 'b' => $value->b, 'c' => $value->c, 'd' => $value->d, 'answer' => $value->answer, 'code_snippet' => $value->code_snippet != '' ? $value->code_snippet : '-', 'answer_exp' => $value->answer_exp != '' ? $value->answer_exp : '-'];
              }
              if(!empty($arr)){
                  \DB::table('questions')->insert($arr);
                  return back()->with('added', 'Question Imported Successfully');
              }
              return back()->with('deleted', 'Your excel file is empty or its headers are not matched to question table fields');
          }
      }
        return back()->with('deleted', 'Request data does not have any files to import');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
          'topic_id' => 'required',
          'question' => 'required',
          'a' => 'required',
          'b' => 'required',
          'c' => 'required',
          'd' => 'required',
          'answer' => 'required',
          'question_img' => 'image'
        ]);

        $input = $request->all();

        if ($file = $request->file('question_img')) {

            $name = 'question_'.time().$file->getClientOriginalName();
            $file->move('images/questions/', $name);
            $input['question_img'] = $name;

        }

        Question::create($input);
        return back()->with('added', 'Question has been added');
    }
     public function descriptiveQuestionStore(Request $request)
    {

        $request->validate([
          'topic_id' => 'required',
          'question' => 'required',
          'marks'    =>'required',
          'question_img' => 'image'
        ]);

        $input = $request->all();
       
        if ($file = $request->file('question_img')) {

            $name = 'question_'.time().$file->getClientOriginalName();
            $file->move('images/questions/', $name);
            $input['question_img'] = $name;

        }

        DescriptiveQuestion::create($input);
        return back()->with('added', 'Question has been added');
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
        $questions = Question::where('topic_id', $topic->id)->get();
        $descriptive = DescriptiveQuestion::where('topic_id', $topic->id)->get();
        $optionals=OptionalMultiple::where('topic_id',$topic->id)->get();
        return view('admin.questions.show', compact('topic', 'questions','descriptive','optionals'));
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
        $question = Question::findOrFail($id);
        $request->validate([
          'topic_id' => 'required',
          'question' => 'required',
          'a' => 'required',
          'b' => 'required',
          'c' => 'required',
          'd' => 'required',
          'answer' => 'required',
        ]);

        $input = $request->all();

        if ($file = $request->file('question_img')) {

            $name = 'question_'.time().$file->getClientOriginalName();

            if($question->question_img != null) {
                unlink(public_path().'/images/questions/'.$question->question_img);
            }

            $file->move('images/questions/', $name);
            $input['question_img'] = $name;

        }

        $question->update($input);
        return back()->with('updated', 'Question has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDescriptiveQuestion(Request $request)
    {
        $question = DescriptiveQuestion::findOrFail($request->id);
        $request->validate([
          'topic_id' => 'required',
          'question' => 'required',
          'marks'=>'required',
          'question_img'=>'image',
        ]);

        $input = $request->all();

        if ($file = $request->file('question_img')) {

            $name = 'question_'.time().$file->getClientOriginalName();

            if($question->question_img != null) {
                unlink(public_path().'/images/questions/'.$question->question_img);
            }

            $file->move('images/questions/', $name);
            $input['question_img'] = $name;

        }

        $question->update($input);
        return back()->with('updated', 'Question has been updated');
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);

        if ($question->question_img != null) {
            unlink(public_path().'/images/questions/'.$question->question_img);
        }

        $question->delete();
        return back()->with('deleted', 'Question has been deleted');
    }
    public function destroyDescriptiveQuestion(Request $request)
    {
      $descriptiveQuestion=DescriptiveQuestion::findOrFail($request->id);
      $descriptiveQuestion->delete();
      return back()->with('deleted', 'Question has been deleted');
    }
    /// All function for the optional multiple  ///
    public function optionalMultiple()
    {
      $topics=Topic::where('test_type','=','2')->get();
      //dd($topics);
      //$optionals=OtionalMultiple::all();
      return view('admin.questions.optionalmultiple',compact('topics','optionals'));
    }
    public function storeOptionalMultipleQuestion(Request $request)
    {
      $request->validate([
          'topic_id' => 'required',
          'question' => 'required',
          'a' => 'required',
          'b' => 'required',
          'c' => 'required',
          'd' => 'required',
          'a_marks' => 'required',
          'b_marks' => 'required',
          'c_marks' => 'required',
          'd_marks' => 'required',
        ]);
      $input=$request->all();
      //dd($input);
      OptionalMultiple::create($input);
      return back()->with('added','OptionalMultiple Question has added');
    }
    public function updateOptionalMultiple(Request $request)
    {
      //dd($request);
      $optional=OptionalMultiple::findOrFail($request->id);
      //dd($optional);
      $request->validate([
          'topic_id' => 'required',
          'question' => 'required',
          'a' => 'required',
          'b' => 'required',
          'c' => 'required',
          'd' => 'required',
          'a_marks' => 'required',
          'b_marks' => 'required',
          'c_marks' => 'required',
          'd_marks' => 'required',
        ]);

      $input=$request->all();
      $optional->update($input);

      return back()->with('updated','optinal question has been update');
    }
    public function deleteOptionalMultiple(Request $request)
    {
      $optional=OptionalMultiple::findOrFail($request->id);
      //dd($optional);
      $optional->delete();
      return back()->with('deleted','Optional multiple question has been deleted');
    }
}






