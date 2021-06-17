<?php

namespace App\Http\Controllers;

use App\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;
use Barryvdh\DomPDF\Facade as PDF;
use Response;

class ApplicationFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('applicationform');
        
    }

    public function SaveApplication(Request $request){
        $request->validate([
          'name' => 'required|string',
          'emailid' => 'required',
          'resume'=>'required|mimes:doc,pdf,docx,zip',
        ]);
        $input = $request->all();
        //dd($input);
        //$fileName = time().'.'.$request->file->extension();  
        //dd($fileName);
        //$request->file->move(public_path('resume'), $fileName);
        $request_file=$request->file('resume');
        $file_name=time()."_".$request_file->getClientOriginalName();
        //dd($file_name);
        $request_file->move('resume',$file_name);
        $application = new Application;

        $application->date = $request->date;
        $application->name = $request->name;
        $application->emailid = $request->emailid;
        $application->positionapplied = $request->positionapplied;
        $application->currency = $request->currency;
        $application->expectedctc = $request->expectedctc;
        $application->expectednegotiable = $request->expectednegotiable;
        $application->noticeperiod = $request->noticeperiod;
        $application->noticenegotiable = $request->noticenegotiable;
        $application->reasonforjobchange = $request->reasonforjobchange;
        $application->employmentdesired = $request->employmentdesired;
        $application->nightshift = $request->nightshift;
        $application->appliedposition = $request->appliedposition;
        $application->jobopportunity = implode(',', $request->jobopportunity);
        $application->others=$request->others;
        /*$application->reference = $request->reference;*/
        $application->resume=$file_name;
        $application->save();
        $applicationid=$application->id;

        $name = $request->name;

        Session::put('userid', $application->id);
        Session::put('emailid', $request->emailid);
        Session::put('name', $name);

        $email = $request->emailid;
        $positionapplied = $request->positionapplied;

        $details = [
            'title' => env('APP_NAME'),
            'email' => $email,
            'name' => ucfirst($name),
            'applicationid'=>$applicationid,
            'positionapplied'=> $positionapplied,
        ];
        
        $mail = \Mail::to($email)->send(new \App\Mail\register($details));

        return redirect()->route('thankyou');
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);
    }

    public function thankyou(){
        return view('thankyou');
    }
    public function download($filename)
    {
           $details =['title' => 'test'];

        $file_path=public_path().'/resume/'.$filename;
        $headers = array('Content-Type: application/pdf',);
        return Response::download($file_path,$filename,$headers);
    
    }
}
