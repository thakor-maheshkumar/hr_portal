<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Hash;
use DB;
use App\Application;
use Carbon\Carbon;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$users = User::where('role', '!=', 'A')->get();
        //$app=Application::firstOrFail()
        $users = User::join('application','application.id','=','users.id')
                    ->where('users.role', '!=', 'A')
                    ->get();
        
        return view('admin.users.indexx', compact('users'));
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
        $request->validate([
          'name' => 'required|string|max:255',
          'email' => 'required|string|email|max:255|unique:users',
          'mobile' => 'unique:users',
          'password' => 'required|string|min:6',
        ]);

        $input = $request->all();

        $user = User::create([
          'name' => $input['name'],
          'email' => $input['email'],
          'password' => bcrypt($input['password']),
          'mobile' => $input['mobile'],
          'address' => $input['address'],
          'city' => $input['city'],
          'role' => $input['role'],
        ]);
        $request_file=$request->file('resume');
        $file_name=time()."_".$request_file->getClientOriginalName();
        
        //dd($file_name);
        $request_file->move('resume',$file_name);
       
        $jobopportunity = implode(',', $input['jobopportunity']);
        Application::create([
            'id' => $user->id,   
            'date' =>Carbon::parse($input['date']),
            'name' => $input['name'],
            'emailid' => $input['email'],
            'positionapplied' => $input['positionapplied'],
            'currency' => $input['currency'],
            'expectedctc' => $input['expectedctc'],
            'expectednegotiable' => $input['expectednegotiable'],
            'noticeperiod' => $input['noticeperiod'],
            'noticenegotiable' => $input['noticenegotiable'],
            'reasonforjobchange' => $input['reasonforjobchange'],
            'employmentdesired' => $input['employmentdesired'],
            'nightshift' => $input['nightshift'],
            'appliedposition' => $input['appliedposition'],
            'jobopportunity' => $jobopportunity,
            'others'=>$input['others'],
            /*'reference' => $input['reference'],*/
            'resume'=>$file_name,
          ]);             

        return back()->with('added', 'User has been added');
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
        $user = User::findOrFail($id);
        $application = Application::findOrFail($id);
        //dd($application);
        $request->validate([
          'name' => 'required|string|max:255',
          'email' => 'required|string|email',
          'password' => 'required|string|min:6',
          'mobile' => 'unique:users,mobile,'.$id,
        ]);
        $input = $request->all();
        if ($file = $request->file('resume')) {

            $name = time().$file->getClientOriginalName();
             
            $request->resume->move(public_path('resume'), $name);

        
            $application['resume']=$name;
        }
        
        if (Auth::user()->role == 'A') {
          $user->update([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
            'mobile' => $input['mobile'],
            'address' => $input['address'],
            'city' => $input['city'],
            'role' => $input['role'],

          ]);

        $jobopportunity = implode(',', $input['jobopportunity']);
        $application->update([
            'date' => $input['date'],
            'name' => $input['name'],
            'emailid' => $input['email'],
            'positionapplied' => $input['positionapplied'],
            'currency' => $input['currency'],
            'expectedctc' => $input['expectedctc'],
            'expectednegotiable' => $input['expectednegotiable'],
            'noticeperiod' => $input['noticeperiod'],
            'noticenegotiable' => $input['noticenegotiable'],
            'reasonforjobchange' => $input['reasonforjobchange'],
            'employmentdesired' => $input['employmentdesired'],
            'nightshift' => $input['nightshift'],
            'appliedposition' => $input['appliedposition'],
            'jobopportunity' => $jobopportunity,
            'others'=>$input['others'],
            /*'reference' => $input['reference'],*/
            //'resume'=>$input['resume'],
          ]);            

        } else if (Auth::user()->role == 'S') {
          $user->update([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
            'mobile' => $input['mobile'],
            'address' => $input['address'],
            'city' => $input['city'],
          ]);
        }

        return back()->with('updated', 'Candidate information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        DB::delete('delete from application where id = ?',[$id]);

        return back()->with('deleted', 'User has been deleted');
    }

}
