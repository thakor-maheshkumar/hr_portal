@extends('layouts.admin', [
  'page_header' => 'Test Wise Candidate Report',
  'dash' => '',
  'quiz' => '',
  'users' => '',
  'questions' => '',
  'top_re' => '',
  'all_re' => 'active',
  'sett' => '',
  'user_re' => '',
  'descriptivescroing' => ''
])

@section('content')
  <div class="row">
    @if ($topics)
      @foreach ($topics as $key => $topic)
      @if($topic->test_type==1)
        <div class="col-md-4">
          <div class="quiz-card">
            <h3 class="quiz-name">{{$topic->title}}</h3>
            <p title="{{$topic->description}}">
              {{str_limit($topic->description, 120)}}
            </p>
            <div class="row">
              <div class="col-xs-6 pad-0">
                <ul class="topic-detail">
                  
                  <li>Total Marks <i class="fa fa-long-arrow-right"></i></li>
                  <li>Total Questions <i class="fa fa-long-arrow-right"></i></li>
                  <li>Total Time <i class="fa fa-long-arrow-right"></i></li>
                </ul>
              </div>
              <div class="col-xs-6 pad-0">
                <ul class="topic-detail right">
                  <li>
                    {{ $topic->que_count }}
                  </li>
                  <li>
                    {{$topic->descriptive_questions_count}}
                  </li>
                  <li>
                    {{$topic->timer}} minutes
                  </li>
                  <li style="height: 20px">
                    
                  </li>
                </ul>
              </div>
            </div>
            <a href="{{route('all_reports.show', $topic->id)}}" class="btn btn-primary">Show Report</a>
          </div>

        </div>
        @else
        <div class="col-md-4">
          <div class="quiz-card">
            <h3 class="quiz-name">{{$topic->title}}</h3>
            <p title="{{$topic->description}}">
              {{str_limit($topic->description, 120)}}
            </p>
            <div class="row">
              <div class="col-xs-6 pad-0">
                <ul class="topic-detail">
                  <li>Marks Per Question <i class="fa fa-long-arrow-right"></i></li>
                  <li>Total Marks <i class="fa fa-long-arrow-right"></i></li>
                  <li>Total Questions <i class="fa fa-long-arrow-right"></i></li>
                  <li>Total Time <i class="fa fa-long-arrow-right"></i></li>
                </ul>
              </div>
              <div class="col-xs-6">
                <ul class="topic-detail right">
                  <li>{{$topic->per_q_mark}}</li>
                  <li>
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
                  </li>
                  <li>
                    {{$qu_count}}
                  </li>
                  <li>
                    {{$topic->timer}} minutes
                  </li>
                </ul>
              </div>
            </div>
            <a href="{{route('all_reports.show', $topic->id)}}" class="btn btn-primary">Show Report</a>
          </div>
        </div>
        @endif

      @endforeach
    @endif
  </div>
@endsection
