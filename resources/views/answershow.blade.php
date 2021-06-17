@extends('layouts.admin', [
  'page_header' => "Candidate Answers",
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
<form method="post" action="{{url('answer_mark_store')}}">
  <input type="hidden" name="_token" value="{{csrf_token()}}">
   @foreach($answers as $answer) 
  <div class="form-group">
    <label for="exampleInputEmail1">Q:{{ $answer->descriptive_question['question'] }}</label>
    <textarea class="form-control ckeditor" id="summary-ckeditor" disabled>{!! $answer->user_answer !!}</textarea>
  </div>
  <label for="exampleInputEmail1">Marks:</label> 
  <div class="row">
  <input type="hidden" name="id[]"  value="{{$answer->id}}">
  <div class="col-sm-2"><input type="text"  class="form-control marks" value="{{$answer->marks}}" name="marks[]" placeholder="marks" id="marks"></div>
  <p class="error" style="display:none">id2 cannot have value less than id1</p>

  <div class="col-sm-1"><input type="text" class="form-control totalmarks" name="" value="{{ $answer->descriptive_question['marks'] }}" disabled></div>
</div>
<br>
  @endforeach
  <br>
  <button type="submit" class="btn btn-primary" id="submit">Submit</button>
</form>
@endsection
@section('scripts')
<script type="text/javascript">
    CKEDITOR.replace( 'summary-ckeditor' );
</script>
<script type="text/javascript">
  $(".totalmarks").focusout(function(){

    if(parseFloat($(".marks").val()) > parseFloat($(".totalmarks").val()))
    {
        $(".error").css("display","block").css("color","red");
        $("#submit").prop('disabled',true);
    }
    else {
        $(".error").css("display","none");
        $("#submit").prop('disabled',false);        
    }

});
</script>
@endsection
