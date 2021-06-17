@extends('layouts.app')
<style type="text/css">
.BirthdayDatePicker .ui-datepicker-year
{
 display:none;   
}
.errorsData{
      color: #F00;
      background-color: #FFF;
   }

</style>
@section('head')
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
  <script>
    window.Laravel =  <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
  </script>
@endsection

@section('top_bar')
<nav class="navbar navbar-default navbar-static-top">
    <div class="logo-main-block">
      <div class="container">
        @if ($setting)
          <a href="{{ url('/') }}" title="{{$setting->welcome_txt}}">
            <img src="{{asset('/images/logo/'. $setting->logo)}}" class="img-responsive" alt="{{$setting->welcome_txt}}">
          </a>
        @endif
      </div>
    </div>
    <div class="nav-bar">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="navbar-header">
              <!-- Branding Image -->
              @if($setting)
                <a class="tt" title="Quick Quiz Home" href="{{url('/')}}"><h4 class="heading">{{$setting->welcome_txt}}</h4></a>
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
              <!-- Right Side Of Navbar -->
              <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                  <li><a href="{{ route('login') }}" title="Login" class="btn btn-primary">Login</a></li>
                  <!-- <li><a href="{{ route('register') }}" title="Register">Register</a></li> -->
                @else
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                      {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                      @if ($auth->role == 'A')
                        <li><a href="{{url('/admin')}}" title="Dashboard">Dashboard</a></li>
                      @elseif ($auth->role == 'S')
                        <li><a href="{{url('/admin/my_reports')}}" title="Dashboard">Dashboard</a></li>
                      @endif
                      <li>
                        <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Logout
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                      </form>
                      </li>
                    </ul>
                  </li>
                 
                  <li><a href="{{ route('faq.get') }}">FAQ</a></li>
                @endguest
                  <!--<li><a href="{{url('pages/how-it-works')}}">How it works</a></li>
                  <li><a href="{{url('pages/about-us')}}">About us</a></li>-->
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
@endsection

@section('content')
<div class="container">
    <div class="quiz-main-block">
    <h3 class="text-center">Employment Application Form</h3>
      <form action="{{ route('SaveApplication') }}" method="POST" name="Application" id="userform" enctype="multipart/form-data">
      {{ csrf_field() }}
            <div class="row">
              <div class="col-md-12">
               <div class="row">
                  <div class="col-xs-3 col-sm-3 col-md-3">
                    <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                      <label for="date">Date:</label>
                      <input type="text" id="date" name="date" class="form-control input-sm" placeholder="Please Enter Date(MM/DD/YYYY)" value="{{date('m/d/Y')}}" required="required" autocomplete="off">
                      <small class="text-danger">{{ $errors->first('date') }}</small>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-3 col-sm-3 col-md-3">
			    					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                      <label for="name">Name:</label>
			    						<input type="text" name="name" id="name" class="form-control input-sm" placeholder="Name" required>
                      <small class="text-danger">{{ $errors->first('name') }}</small>
			    					</div>
			    				</div>
			    			</div>
                <div class="row">
			    				<div class="col-xs-3 col-sm-3 col-md-3">
			    					<div class="form-group{{ $errors->has('emailid') ? ' has-error' : '' }}">
                      <label for="emailid">Email ID:</label>
			                <input type="email" name="emailid" id="emailid" class="form-control input-sm" placeholder="Please enter email ID" required="required">
                      <small class="text-danger">{{ $errors->first('emailid') }}</small>
			    					</div>
			    				</div>
			    			</div>  
                <div class="row">
                  <div class="col-xs-3 col-sm-3 col-md-3">
                    <div class="form-group{{ $errors->has('positionapplied') ? ' has-error' : '' }}">
                      <label for="positionapplied">Position applied for:</label>
                      <input type="text" name="positionapplied" id="positionapplied" class="form-control input-sm" placeholder="Please enter position applied for" required="required">
                      <small class="text-danger">{{ $errors->first('positionapplied') }}</small>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-3 col-sm-3 col-md-3">
                    <div class="form-group{{ $errors->has('expectedctc') ? ' has-error' : '' }}">
                      <label for="expectedctc" id="expectedctclable" >Expected Salary (Per Annum):</label>
                      <select name="currency" class="form-control" required="required" id="currency">
                        <option value="INR">INR</option>
                        <option value="GBP">GBP</option>
                        <option value="USD">USD</option>
                        <option value="AED">AED</option>
                        <option value="AUD">AUD</option>
                      </select>
                      <input type="number" name="expectedctc" id="expectedctc" class="form-control input-sm" placeholder="Expected Salary " required="required"
                      min="0" oninput="validity.valid||(value='');" style="width: 196px">
                      <small class="text-danger">{{ $errors->first('expectedctc') }}</small>
                    </div>
			    				</div>
			    				<div class="col-xs-3 col-sm-3 col-md-3">
			    					<div class="form-group">
                      <label>&nbsp;</label><br>
                      <label class="radio-inline-text">Negotiable:</label>
                      <label class="checkbox-inline">
                        <input type="radio" name="expectednegotiable" value="1" required="required"> Yes
                      </label>
                      <label class="checkbox-inline">
                        <input type="radio" name="expectednegotiable" value="0" required="required"> No
                      </label>
			    					</div>
			    				</div>
			    			</div>  

                <div class="row">
                  <div class="col-xs-3 col-sm-3 col-md-3">
                    <div class="form-group{{ $errors->has('noticeperiod') ? ' has-error' : '' }}">
                      <label for="noticeperiod">Notice Period (Days):</label>
                      <input type="number" name="noticeperiod" id="noticeperiod" class="form-control input-sm" placeholder="Please enter notice period (Days)" required="required" min="0" oninput="validity.valid||(value='');">
                      <small class="text-danger">{{ $errors->first('noticeperiod') }}</small>
                    </div>
			    				</div>
			    				<div class="col-xs-3 col-sm-3 col-md-3">
			    					<div class="form-group">
                      <label>&nbsp;</label><br>
                      <label class="radio-inline-text">Negotiable:</label>
                      <label class="checkbox-inline">
                        <input type="radio" name="noticenegotiable" value="1" required="required"> Yes
                      </label>
                      <label class="checkbox-inline">
                        <input type="radio" name="noticenegotiable" value="0" required="required"> No
                      </label>
			    					</div>
			    				</div>
			    			</div>    

                <div class="row">
                  <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group{{ $errors->has('reasonforjobchange') ? ' has-error' : '' }}">
                      <label for="reasonforjobchange">Reason for Job Change:</label>
                      <textarea placeholder="Please enter reason for job change" name="reasonforjobchange" cols="50" rows="1" id="reasonforjobchange" class="form-control" required="required"></textarea>
                      <small class="text-danger">{{ $errors->first('reasonforjobchange') }}</small>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-9 col-sm-9 col-md-9">
                    <div class="form-group">
                    <label class="radio-inline-text" for="employmentdesired">Employment Desired:</label>
                      <label class="checkbox-inline">
                        <input type="radio" name="employmentdesired" value="FULL-TIME ONLY" required="required"> Full-time only
                      </label>
                      <label class="checkbox-inline">
                        <input type="radio" name="employmentdesired" value="PART-TIME ONLY" required="required"> Part-time only
                      </label>
                      <label class="checkbox-inline">
                        <input type="radio" name="employmentdesired" value="FULL- OR PART-TIME" required="required"> Full or part-time
                      </label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-9 col-sm-9 col-md-9">
                    <div class="form-group">
                    <label class="radio-inline-text" for="nightshift">Are you open to working in a night shift?</label>
                      <label class="checkbox-inline">
                        <input type="radio" name="nightshift" value="1" required="required"> Yes
                      </label>
                      <label class="checkbox-inline">
                        <input type="radio" name="nightshift" value="0" required="required"> No
                      </label>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                    <label class="radio-inline-text" for="appliedposition">Have you applied for any position at The Annet Group in the last 6 months / worked with The Annet Group? </label>
                      <label class="checkbox-inline">
                        <input type="radio" name="appliedposition" value="1" required="required"> Yes
                      </label>
                      <label class="checkbox-inline">
                        <input type="radio" name="appliedposition" value="0" required="required"> No
                      </label>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group{{ $errors->has('reasonforjobchange') ? ' has-error' : '' }}">
                    <label class="radio-inline-text" for="jobopportunity">How did you come to know about this job opportunity? </label>
                      <label class="checkbox-inline">
                        <input type="checkbox" name="jobopportunity[]" value="Call from HR">Call from HR
                      </label>
                      <label class="checkbox-inline">
                        <input type="checkbox" name="jobopportunity[]" value="Consultant">Consultant
                      </label>
                      <label class="checkbox-inline">
                        <input type="checkbox" name="jobopportunity[]" value="Posting on the job portal">Posting on the job portal
                      </label>
                      <label class="checkbox-inline">
                        <input type="checkbox" name="jobopportunity[]" value="Company Website">Company Website
                      </label>
                      <label class="checkbox-inline">
                        <input type="checkbox" name="jobopportunity[]" value="Employee reference">Employee reference
                      </label>
                      <label class="checkbox-inline">
                        <input type="checkbox" name="others" value="Others">Others
                      </label>
                      <div class="row jobopportunity">
                    <div class="col-xs-3 col-sm-3 col-md-3">
                      <div class="jobopportunity" style=display:none;>
                      <textarea name="others" cols="15" rows="2" cols="25" rows="0" placeholder="Please enter others" style="width: 260px;height: 40px"></textarea>
                      </div>
                    </div>
                  </div>
                    </div>
                  </div>
                </div>
                <!-- <div class="row">
                  <div class="col-xs-3 col-sm-3 col-md-3">
                    <div class="form-group{{ $errors->has('reference') ? ' has-error' : '' }}">
                      <label for="reference">Employee Reference(If any)</label>
                      <textarea placeholder="Please Enter Employee Reference" name="reference" cols="25" rows="1" id="reference" class="form-control" required="required"></textarea>
                      <small class="text-danger">{{ $errors->first('reference') }}</small>
                    </div>
                  </div>
                </div> -->
                <div class="row">
                  <div class="col-xs-3 col-sm-3 col-md-3">
                    <div class="form-group{{ $errors->has('resume') ? ' has-error' : '' }}">
                      <label for="reference">Upload Resume</label>
                      <!-- <textarea placeholder="Please Enter Employee Reference" name="reference" cols="25" rows="1" id="reference" class="form-control" required="required"></textarea>
                      <small class="text-danger">{{ $errors->first('reference') }}</small> -->
                      <input type="file" name="resume" placeholder="please upload your resume" id="resume" >
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="row">
              <div class="btn-group pull-left col-sm-12">
                  <input type="submit" value="Submit Application" class="btn btn-primary">
              </div>
            </div>
        </form>
      </div>
</div>
@endsection