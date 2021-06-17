<?php

namespace App\Http\Controllers;

use App\usertopics;
use App\User;
use App\Topic;
use Illuminate\Http\Request;
use DB;

class UsertopicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$usertopicss = usertopics::all();
        $usertopicss = usertopics::select('user_topic_mapping.id','users.id','user_topic_mapping.user_id','users.name',DB::raw('group_concat(topics.title) as title'))
                ->join('users', 'users.id', '=', 'user_topic_mapping.user_id')
                ->join('topics', 'user_topic_mapping.topic_id', '=', 'topics.id')
                ->groupBy('user_topic_mapping.user_id')    
                ->get();
        return view('admin.usertopics.index',compact('usertopicss'));
        
    }
     
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_topic_mapping = usertopics::groupBy('user_id')    
                    ->get();
        $data = array();
        foreach ($user_topic_mapping as $user) {
            $data[] = $user->user_id;
        }            
        $users = User::where('role', '!=', 'A')->whereNotIn('id', $data)->get();
        $Topic = Topic::all();
        return view('admin.usertopics.add',compact('users','Topic'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(isset($request->topic)){
        foreach($request->topic as $topic){
            $newusertopics = new usertopics;
            $newusertopics->user_id = $request->user_id;
            $newusertopics->topic_id = $topic;
            $newusertopics->save();
        }    
        }
        return redirect()->route('usertopics.index')->with('added','Usertopics Added');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\usertopics  $usertopics
     * @return \Illuminate\Http\Response
     */
    public function show(usertopics $usertopics)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\usertopics  $usertopics
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usertopics = usertopics::findOrFail($id);
      return view('admin.usertopics.edit',compact('usertopics'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\usertopics  $usertopics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
         $usertopics = usertopics::findOrFail($id);
        $usertopics->title = $request->title;
        $usertopics->details = $request->details;
        $usertopics->save();

        return redirect()->route('usertopics.index')->with('updated','Usertopics is updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\usertopics  $usertopics
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('user_topic_mapping')->where('user_id', $id)->delete();
        return redirect()->route('usertopics.index')->with('deleted','Assign test has been deleted');
    }
}
