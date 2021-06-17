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
<div class="content-block box">
    <div class="box-body table-responsive">
<table class="table">
  <p style="font-weight: bold;text-align: center;font-size: 30px">Interpretation of Scores: (P - Stands for percentile)</p>
  <thead>
    <tr>
      <th>EQ Dimensions</th>
      <th>P-90 (Extremely High EQ)</th>
      <th>P-75  (High EQ)</th>
      <th>P-50  (Moderate EQ)</th>
      <th>P-40 (Low EQ)</th>
      <th>P-20 Try the test some other day</th>
    </tr>
  </thead>
  <tbody>
        <td>Total EQ(Range of score: 110 - 440)</td>

        <td @if($answerss <=440 && $answerss >=311) style="background-color:green" @endif>311 - 440 @if($answerss <= 440 && $answerss >= 311) <br>Total Marks--<?php echo $answerss; ?> @endif</td>
        
        <td @if($answerss <= 310 && $answerss >= 271) style="background-color:green" @endif>271 - 310
        @if($answerss <= 310 && $answerss >= 271)<br>Total Marks--<?php echo $answerss;?> @endif</td>
        
        <td @if($answerss <= 270 && $answerss >= 201) style="background-color:green" @endif>201 - 270
        @if($answerss <= 270 && $answerss >= 201) <br>Total Marks--<?php echo $answerss;?> @endif</td>

        <td @if($answerss <= 200 && $answerss >= 126) style="background-color:green" @endif>126 - 200 @if($answerss <= 210 && $answerss >= 126)<br>Total Marks--<?php echo $answerss;?> @endif</td>

        <td @if($answerss<=125)  style="background-color:green" @endif> < 125 <br>@if($answerss <=125) <br>Totak Marks--<?php echo $answerss; ?>@endif</td>
  </tbody>
</table>
</div>
</div>
@endsection
@section('scripts')
<!-- <script type="text/javascript">
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
 -->@endsection
