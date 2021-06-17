@extends('layouts.app')
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
                <a class="tt" title="Quick Quiz Home" href="{{url('/')}}"><h4 class="heading text-capitalize">{{$setting->welcome_txt}}</h4></a>
              @endif
              <h6>Online Assessment</h6>
            </div>
          </div>
          <div class="col-md-6">
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
              <!-- Right Side Of Navbar -->
              <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                  <li><a href="{{ route('login') }}" title="Login" class="btn btn-primary header_loginbtn_mt">Login</a></li>
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
                        <!-- <li><a href="{{url('/admin/my_reports')}}" title="Dashboard">Dashboard</a></li> -->
                        <li><a href="{{url('/admin/profile')}}" title="Profile">Profile</a></li>
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
                 
                  <!-- <li><a href="{{ route('faq.get') }}">FAQ</a></li> -->
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

<div class="container ">

  @if ($auth)
    <div class="quiz-main-block">
      <div class="row">
        @if ($topics && count($topics) != 0)
          @foreach ($topics as $topic)
            <div class="col-md-4">
              <div class="topic-block">
                <div class="card">
                  <div class="card-content white-text">
                    <span class="card-title">{{$topic->title}}</span>
                    <p title="{{$topic->description}}">{{str_limit($topic->description, 120)}}</p>
                    <div class="row">
                      <div class="col-md-12">
                        @if($topic->test_type==1)
                        <span class="btn btn-default">
                          <small>Total Marks:</small>
                          <b>
                          {{$topic->que_count}}
                          </b>
                          </span>
                        <span class="btn btn-default pull-right">
                          <small>Total Questions </small>
                            <b>
                              {{$topic->descriptive_questions_count}}
                            </b>
                          </span>
                          @else
                          <span class="btn btn-default">
                          <small>Total Marks  </small>
                          <b>
                          @php
                                  $qu_count = 0;
                              @endphp
                              @foreach($questions as $question)
                                @if($question->topic_id == $topic->id)
                                  @php 
                                    $qu_count++;
                                  @endphp
                                @endif
                              @endforeach
                              {{$topic->per_q_mark*$qu_count}}
                            </b>
                          </span>
                        <span class="btn btn-default pull-right">
                          <small>Total Questions:</small>
                            <b>
                              {{$qu_count}}
                            </b>
                          </span>
                          @endif
                          </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4 pad-0">
                        <ul class="topic-detail row">
                          @if($topic->test_type==1)

                          @else
                          <li class="col-xs-12 text-center"><small>Per Question</small></li>
                          <li class="col-xs-12 text-center"><b>{{$topic->per_q_mark}} Mark</b></li>
                          @endif
                        </ul>
                      </div>
                      <div class="col-sm-4 pad-0">
                        <ul class="topic-detail row">
                          <li class="col-xs-12 text-center"><small>Total Time</small></li>
                          <li class="col-xs-12 text-center"><b>{{$topic->timer}} minutes</b></li>
                        </ul>
                      </div>
                      <!-- <div class="col-sm-4 pad-0">
                        <ul class="topic-detail row">
                          <li class="col-xs-12 text-center"><small>Quiz Price</small></li>
                          <li class="col-xs-12 text-center"><b>@if(!empty($topic->amount))
                            {{-- <i class="{{$setting->currency_symbol}}"></i> {{$topic->amount}}   --}}
                             @else
                               Free
                            @endif</b></li>
                        </ul>
                      </div> -->
                    </div>
                  </div>


               <div class="card-action text-center">
                  
                  @if (Session::has('added'))
                    <div class="alert alert-success sessionmodal">
                      {{session('added')}}
                    </div>
                  @elseif (Session::has('updated'))
                    <div class="alert alert-info sessionmodal">
                      {{session('updated')}}
                    </div>
                  @elseif (Session::has('deleted'))
                    <div class="alert alert-danger sessionmodal">
                      {{session('deleted')}}
                    </div>
                  @endif

                    @if($auth->topic()->where('topic_id', $topic->id)->exists())
                      <a href="{{route('start_quiz', ['id' => $topic->id])}}" class="btn btn-block" title="Start Quiz"><span>Start Quiz</span></a>
                    @else
                      {!! Form::open(['method' => 'POST', 'action' => 'PaypalController@paypal_post']) !!} 
                        {{ csrf_field() }}
                        <input type="hidden" name="topic_id" value="{{$topic->id}}"/>
                         @if(!empty($topic->amount)) 

                        <button type="submit" class="btn btn-default">Pay  <i class="{{$setting->currency_symbol}}"></i>{{$topic->amount}}</button>
                          @else 

                          <a href="{{route('start_quiz', ['id' => $topic->id])}}" class="btn btn-block" title="Start Quiz"><span>Start Test</span> </a>

                        @endif

                      {!! Form::close() !!}
                    @endif
                  </div>


                {{--   <div class="card-action">
                    @php 
                      $a = false;
                      $que_count = $topic->question ? $topic->question->count() : null;
                      $ans = $auth->answers;
                      $ans_count = $ans ? $ans->where('topic_id', $topic->id)->count() : null;
                      if($que_count && $ans_count && $que_count == $ans_count){
                        $a = true;
                      }
                    @endphp
                    <a href="{{$a ? url('start_quiz/'.$topic->id.'/finish') : route('start_quiz', ['id' => $topic->id])}}" class="btn btn-block" title="Start Quiz">Start Test
                    </a>
                  </div> --}}
                </div>
              </div>
            </div>
          @endforeach
        @else
            <div class="quiz-main-block">
              <h3 class="text-center">Thank you!</h3>
              <h3 class="text-center">Please contact Annet HR for further process.</h3>
            </div>
        @endif
      </div>
    </div>
  @endif
  @if (!$auth)
    <div class="row">
        <div class="col-md-8 col-md-offset-2 home-main-block text-center">
        <div class="row">
        <h1>Online Assessment Platform for Hiring & Workforce Development</h1>
        	<div class="col-md-6">
            	<p>Customized assessment tests for hiring and workforce development for The Annet Group. Our assessment platform and online test system help administer online assessment tests and can be accessed anywhere, anytime and on any device by candidates applying for employment with The Annet Group.</p>
            </div>
            <div class="col-md-6">
            <img src="{{asset('/images/home_bg.png')}}" class="img-responsive">
            </div>
            
        </div>
        <div class="row text-center">
        	<a href="{{ route('applicationform') }}" class="btn btn-primary">Register Here</a>
        </div>
             <!--<div class="home-main-block text-center">
             @if ($setting)
                <h1 class="main-block-heading text-center">{{$setting->welcome_txt}}</h1>
              @endif
              
              
                <blockquote>
                  Please <a href="{{ route('login') }}">Login</a> To Start Quiz >>>
                  <a href="{{ route('applicationform') }}">Start Online Exam click here</a> >>>
                </blockquote>
                
            </div>-->
        </div>
    </div>
  
  @endif
</div>


@endsection

@section('scripts')

<script>
   $( document ).ready(function() {
       $('.sessionmodal').addClass("active");
       setTimeout(function() {
           $('.sessionmodal').removeClass("active");
      }, 4500);
    });
</script>


 @if($setting->right_setting == 1)
  <script type="text/javascript" language="javascript">
   // Right click disable
    $(function() {
    $(this).bind("contextmenu", function(inspect) {
    inspect.preventDefault();
    });
    });
      // End Right click disable
  </script>
@endif

@if($setting->element_setting == 1)
<script type="text/javascript" language="javascript">
//all controller is disable
      $(function() {
      var isCtrl = false;
      document.onkeyup=function(e){
      if(e.which == 17) isCtrl=false;
}

      document.onkeydown=function(e){
       if(e.which == 17) isCtrl=true;
      if(e.which == 85 && isCtrl == true) {
     return false;
    }
 };
      $(document).keydown(function (event) {
       if (event.keyCode == 123) { // Prevent F12
       return false;
  }
      else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I
     return false;
   }
 });
});
     // end all controller is disable
 </script>


@endif
@endsection
