@extends('layouts.admin', [
  'page_header' => 'Assign New Test',
  'dash' => '',
  'quiz' => '',
  'users' => '',
  'questions' => '',
  'top_re' => '',
  'all_re' => '',
  'sett' => '',
  'user_re' => 'active',
  'descriptivescroing' => ''
])

@section('content')
  <div class="box">
    <div class="box-body">
    <form class="col-md-8" action="{{ route('usertopics.store') }}" method="POST" id="topicassingform">
      {{ csrf_field() }}
      <label for="name">User List:</label>

      <select name="user_id" class="form-control required" id="user_id">
        <option value="">--Select User--</option>
        @foreach($users as $user)
        <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
      </select>
      <br>
      <label for="name">Test List:</label><br>
      <span id="errorToShow"></span>
      @foreach($Topic as $Topics)
      <br>
      <input type="checkbox"  name="topic[]" value="{{$Topics->id}}"  /> {{$Topics->title}} <br>
      <span class="checkmark"></span>

      @endforeach

      <br>
      <button type="submit" class="btn btn-primary btn-md">
        <i class="fa fa-plus"></i> Assign Test to Candidate
      </button>
    </form>
    </div>
  </div>
@endsection