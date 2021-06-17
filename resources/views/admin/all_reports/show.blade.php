@extends('layouts.admin', [
  'page_header' => "Candidate report / {$topic->title}",
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
  <div class="content-block box">
    <div class="box-body table-responsive">
      <table id="topTable" class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Candidate Name</th>
            <th>Mobile No.</th>            
            <th>Topic</th>
            <th>Marks Got</th>
            <th>Total Marks</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @if ($answers)
            @foreach ($filtStudents as $key => $student)
              <tr>
                <td>
                  {{$key+1}}
                </td>
                <td>{{$student->name}}</td>
                <td>{{$student->mobile}}</td>               
                <td>{{$topic->title}}</td>
                <td style="text-align:center;">

                  @if($topic->test_type==1)

                  {{$student->total_marks}}

                  @elseif($topic->test_type==2)
                  
                  {{$student->total_optional_marks}}

                  @else

                    @php
                    $mark = 0;
                    $correct = collect();
                    @endphp

                    @foreach ($answers as $answer)

                    @if ($answer->user_id == $student->id && $answer->answer == $answer->user_answer)

                      @php

                       $mark++;

                      @endphp
                    @endif
                  @endforeach

                  @php
                    $correct = $mark*$topic->per_q_mark;
                  @endphp
                   {{$correct}}
                  @endif
                </td>
                <td style="text-align: center;">
                  @if($topic->test_type==1)
                   {{$sumTotalMarks}}
                  @else
                  {{$c_que*$topic->per_q_mark}}
                  @endif
                </td>
                <td>
                  <a data-toggle="modal" data-target="#delete{{ $topic->id }}" title="It will delete the answer sheet of this student" href="#" class="btn btn-sm btn-warning">
                    Reset Response
                  </a>
                  @if($topic->test_type==1)
                  <a href="{{url('answer/show')}}/{{$student->id}}/{{$topic->id}}" class="btn btn-sm btn-success" style="width: 100px">
                    View 
                  </a>
                  @elseif($topic->test_type==2)
                  <a href="{{url('/optional/marksshow/')}}/{{$student->id}}/{{$topic->id}}" class="btn btn-sm btn-success" style="width: 100px">
                    ViewData 
                  </a>
                  @endif
                  <div id="delete{{ $topic->id }}" class="delete-modal modal fade" role="dialog">
                      <!-- Delete Modal -->
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <div class="delete-icon"></div>
                          </div>
                          <div class="modal-body text-center">
                            <h4 class="modal-heading">Are You Sure ?</h4>
                            <p>Do you really want to delete these record? This process cannot be undone.</p>
                          </div>
                          <div class="modal-footer">
                            {!! Form::open(['method' => 'DELETE', 'action' => ['AllReportController@delete', 'topicid' => $topic->id, 'userid' => $student->id] ]) !!}
                                {!! Form::reset("No", ['class' => 'btn btn-gray', 'data-dismiss' => 'modal']) !!}
                                {!! Form::submit("Yes", ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                          </div>
                        </div>
                      </div>
                    </div>
                </td>
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>
@endsection

