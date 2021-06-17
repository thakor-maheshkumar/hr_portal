@extends('layouts.admin', [
  'page_header' => "Questions / {$topic->title} ",
  'dash' => '',
  'quiz' => '',
  'users' => '',
  'questions' => 'active',
  'top_re' => '',
  'all_re' => '',
  'sett' => '',
  'user_re' => '',
  'descriptivescroing' => ''
])

@section('content')
  <div class="margin-bottom">
    <button type="button" class="btn btn-wave" data-toggle="modal" data-target="#createModal">Add Question</button>
    @if($topic->test_type==0)
    <!-- <button type="button" class="btn btn-wave" data-toggle="modal" data-target="#importQuestions">Import Questions</button> -->
    @endif
  </div>
  <!-- Create Modal -->
  @if($topic->test_type=='0')
  <div id="createModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Question</h4>
        </div>
        {!! Form::open(['method' => 'POST', 'action' => 'QuestionsController@store', 'files' => true,'id'=>'addquestion']) !!}
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4">
                {!! Form::hidden('topic_id', $topic->id) !!}
                <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">              
                  {!! Form::label('question', 'Question') !!}
                  <span class="required">*</span>
                  {!! Form::textarea('question', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Question', 'rows'=>'8', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('question') }}</small>
                </div>
                <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                    {!! Form::label('answer', 'Correct Answer') !!}
                    <span class="required">*</span>
                    {!! Form::select('answer', array('A'=>'A', 'B'=>'B', 'C'=>'C', 'D'=>'D'),null, ['class' => 'form-control select2', 'required' => 'required', 'placeholder'=>'']) !!}
                    <small class="text-danger">{{ $errors->first('answer') }}</small>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group{{ $errors->has('a') ? ' has-error' : '' }}">
                  {!! Form::label('a', 'A - Option') !!}
                  <span class="required">*</span>
                  {!! Form::text('a', null, ['class' => 'form-control', 'placeholder' => 'Please Enter A Option', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('a') }}</small>
                </div>
                <div class="form-group{{ $errors->has('b') ? ' has-error' : '' }}">
                  {!! Form::label('b', 'B - Option') !!}
                  <span class="required">*</span>
                  {!! Form::text('b', null, ['class' => 'form-control', 'placeholder' => 'Please Enter B Option', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('b') }}</small>
                </div>
                <div class="form-group{{ $errors->has('c') ? ' has-error' : '' }}">
                  {!! Form::label('c', 'C - Option') !!}
                  <span class="required">*</span>
                  {!! Form::text('c', null, ['class' => 'form-control', 'placeholder' => 'Please Enter C Option', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('c') }}</small>
                </div>
                <div class="form-group{{ $errors->has('d') ? ' has-error' : '' }}">
                  {!! Form::label('d', 'D - Option') !!}
                  <span class="required">*</span>
                  {!! Form::text('d', null, ['class' => 'form-control', 'placeholder' => 'Please Enter D Option', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('d') }}</small>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group{{ $errors->has('code_snippet') ? ' has-error' : '' }}">
                    {!! Form::label('code_snippet', 'Code Snippets') !!}
                    {!! Form::textarea('code_snippet', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Code Snippets', 'rows' => '5']) !!}
                    <small class="text-danger">{{ $errors->first('code_snippet') }}</small>
                </div>
                <div class="form-group{{ $errors->has('answer_ex') ? ' has-error' : '' }}">
                    {!! Form::label('answer_exp', 'Answer Explanation') !!}
                    {!! Form::textarea('answer_exp', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Answer Explanation', 'rows' => '4']) !!}
                    <small class="text-danger">{{ $errors->first('answer_ex') }}</small>
                </div>
              </div>
              <div class="col-md-12">
                <div class="extras-block">
                  <h4 class="extras-heading">Video And Image For Question</h4>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group{{ $errors->has('question_video_link') ? ' has-error' : '' }}">
                        {!! Form::label('question_video_link', 'Add Video To Question') !!}
                        {!! Form::text('question_video_link', null, ['class' => 'form-control', 'placeholder'=>'https://myvideolink.com/embed/..']) !!}
                        <small class="text-danger">{{ $errors->first('question_video_link') }}</small>
                        <p class="help">YouTube And Vimeo Video Support (Only Embed Code Link)</p>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group{{ $errors->has('question_img') ? ' has-error' : '' }}">
                        {!! Form::label('question_img', 'Add Image To Question') !!}
                        {!! Form::file('question_img') !!}
                        <small class="text-danger">{{ $errors->first('question_img') }}</small>
                         <p class="help">Please Choose Only .JPG, .JPEG and .PNG</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="btn-group pull-right">
              {!! Form::reset("Reset", ['class' => 'btn btn-default','style' =>'margin-right:16px']) !!}
              {!! Form::submit("Add", ['class' => 'btn btn-success','style'=>'width: 55px']) !!}
            </div>
          </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
  @elseif($topic->test_type=='2')
  <div id="createModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Question</h4>
        </div>
        {!! Form::open(['method' => 'POST', 'action' => 'QuestionsController@storeOptionalMultipleQuestion', 'files' => true,'id'=>'optionmultiple']) !!}
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4">
                {!! Form::hidden('topic_id', $topic->id) !!}
                <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">              
                  {!! Form::label('question', 'Question') !!}
                  <span class="required">*</span>
                  {!! Form::textarea('question', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Question', 'rows'=>'8', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('question') }}</small>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group{{ $errors->has('a') ? ' has-error' : '' }}">
                  {!! Form::label('a', 'A - Option') !!}
                  <span class="required">*</span>
                  {!! Form::text('a', null, ['class' => 'form-control', 'placeholder' => 'Please Enter A Option', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('a') }}</small>
                </div>
                <div class="form-group{{ $errors->has('b') ? ' has-error' : '' }}">
                  {!! Form::label('b', 'B - Option') !!}
                  <span class="required">*</span>
                  {!! Form::text('b', null, ['class' => 'form-control', 'placeholder' => 'Please Enter B Option', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('b') }}</small>
                </div>
                <div class="form-group{{ $errors->has('c') ? ' has-error' : '' }}">
                  {!! Form::label('c', 'C - Option') !!}
                  <span class="required">*</span>
                  {!! Form::text('c', null, ['class' => 'form-control', 'placeholder' => 'Please Enter C Option', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('c') }}</small>
                </div>
                <div class="form-group{{ $errors->has('d') ? ' has-error' : '' }}">
                  {!! Form::label('d', 'D - Option') !!}
                  <span class="required">*</span>
                  {!! Form::text('d', null, ['class' => 'form-control', 'placeholder' => 'Please Enter D Option', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('d') }}</small>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Option A Marks</label>
                  <input type="number" name="a_marks" class="form-control" oninput="validity.valid||(value='');" placeholder="option a marks" required="required">
                </div> 
                <div class="form-group">
                  <label>Option B Marks</label>
                  <input type="number" name="b_marks" class="form-control" oninput="validity.valid||(value='');" placeholder="option b marks" required="required">
                </div>
                <div class="form-group">
                  <label>Option C Marks</label>
                  <input type="number" name="c_marks" class="form-control" oninput="validity.valid||(value='');" placeholder="option c marks" required="required">
                </div>
                <div class="form-group">
                  <label>Option D Marks</label>
                  <input type="text" name="d_marks" class="form-control" placeholder="option d marks" required="required">
                </div>
              </div>
              
            </div>
          </div>
          <div class="modal-footer">
            <div class="btn-group pull-right">
              {!! Form::reset("Reset", ['class' => 'btn btn-default','style' =>'margin-right:16px']) !!}
              {!! Form::submit("Add", ['class' => 'btn btn-success','style'=>'width: 55px']) !!}
            </div>
          </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
  
  @else
  <div id="createModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Question</h4>
        </div>
        {!! Form::open(['method' => 'POST', 'url'=>'admin/descriptive/questionsstore', 'files' => true,'id'=>'adddescriptivequestion']) !!}
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                {!! Form::hidden('topic_id', $topic->id) !!}
                <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">                  
                  {!! Form::label('question', 'Question') !!}
                  <span class="required">*</span>
                  {!! Form::textarea('question', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Question', 'rows'=>'3', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('question') }}</small>
                </div>
                <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                    {!! Form::label('answer', 'Marks') !!}
                    <span class="required">*</span>
                    {!! Form::text('marks', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Marks', 'rows'=>'8', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('answer') }}</small>
                </div>
              </div>
              <div class="col-md-12">
                <div class="extras-block">
                  <h4 class="extras-heading">Image For Question</h4>
                  <div class="row">
                      <div class="col-md-6">
                      <div class="form-group{{ $errors->has('question_img') ? ' has-error' : '' }}">
                        {!! Form::label('question_img', 'Add Image To Question') !!}
                        {!! Form::file('question_img') !!}
                        <small class="text-danger">{{ $errors->first('question_img') }}</small>
                         <p class="help">Please Choose Only .JPG, .JPEG and .PNG</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
           <div class="btn-group pull-right">
              {!! Form::reset("Reset", ['class' => 'btn btn-default','style' =>'margin-right:16px']) !!}
              {!! Form::submit("Add", ['class' => 'btn btn-success','style'=>'width: 55px']) !!}
            </div>
          </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>

  @endif
  <!-- Import Questions Modal -->
  <div id="importQuestions" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Import Questions (Excel File With Exact Header of DataBase Field)</h4>
        </div>
        {!! Form::open(['method' => 'POST', 'action' => 'QuestionsController@importExcelToDB', 'files' => true]) !!}
          <div class="modal-body">
            {!! Form::hidden('topic_id', $topic->id) !!}
            <div class="form-group{{ $errors->has('question_file') ? ' has-error' : '' }}">
              {!! Form::label('question_file', 'Import Question Via Excel File', ['class' => 'col-sm-3 control-label']) !!}
              <span class="required">*</span>
              <div class="col-sm-9">
                {!! Form::file('question_file', ['required' => 'required']) !!}
                <p class="help-block">Only Excel File (.CSV and .XLS)</p>
                <small class="text-danger">{{ $errors->first('question_file') }}</small>
              </div>
            </div>
          </div>
          <div class="modal-footer">
           <div class="btn-group pull-right">
              {!! Form::reset("Reset", ['class' => 'btn btn-default','style' =>'margin-right:16px']) !!}
              {!! Form::submit("Add", ['class' => 'btn btn-success','style'=>'width: 55px']) !!}
            </div>
          </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
  @if($topic->test_type=='0')
  <div class="box">
    <div class="box-body table-responsive">
      <table id="questions_table" class="table table-hover table-striped new">
        <thead>
          <tr>
            <th style="width: 60px;">Sr.No</th>
            <th>Questions</th>

            <th>A - Option</th>
            <th>B - Option</th>
            <th>C - Option</th>
            <th>D - Option</th>
            <th style="width: 150px;">Correct Answer</th>
            <!-- <th>Code Snippet</th> -->
            <!-- <th>Answer Explanation</th> -->
            <!-- <th class="text-center">Image</th> -->
            <!-- <th>Video Link</th> -->
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @if ($questions)
            @foreach ($questions as $key => $question)
              @php
                $answer = strtolower($question->answer);
              @endphp
              <tr>
                <td>
                  {{$key+1}}
                </td>
                <td>{{$question->question}}</td>
                <td>{{$question->a}}</td>
                <td>{{$question->b}}</td>
                <td>{{$question->c}}</td>
                <td>{{$question->d}}</td>
                <td style="width: 100px;">{{$question->$answer}}</td>
                <!-- <td>
                  <pre>
                    {{{$question->code_snippet}}}
                  </pre>
                </td> -->
                <!-- <td>
                  {{$question->answer_exp}}
                </td> -->
                <!-- <td>
                  <img src="{{asset('/images/questions/'.$question->question_img)}}" class="img-responsive" alt="image">
                </td> -->
                <!-- <td>
                  {{$question->question_video_link}}
                </td> -->
                <td>
                  <!-- Edit Button -->
                  <a type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#{{$question->id}}EditModal" ><i class="fa fa-edit"></i> Edit</a>
                  <!-- Delete Button -->
                  <a type="button" class="btn btn-danger btn-xs " data-toggle="modal" data-target="#{{$question->id}}deleteModal" style="margin-top: 5px"><i class="fa fa-close"></i> Delete</a>
                  <div id="{{$question->id}}deleteModal" class="delete-modal modal fade" role="dialog">
                    <!-- Delete Modal -->
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <div class="delete-icon"></div>
                        </div>
                        <div class="modal-body text-center">
                          <h4 class="modal-heading">Are You Sure ?</h4>
                          <p>Do you really want to delete these records? This process cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                          {!! Form::open(['method' => 'DELETE', 'action' => ['QuestionsController@destroy', $question->id]]) !!}
                            {!! Form::reset("No", ['class' => 'btn btn-gray', 'data-dismiss' => 'modal']) !!}
                            {!! Form::submit("Yes", ['class' => 'btn btn-danger']) !!}
                          {!! Form::close() !!}
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <!-- edit model -->
              <div id="{{$question->id}}EditModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Edit Question</h4>
                    </div>
                    {!! Form::model($question, ['method' => 'PATCH', 'action' => ['QuestionsController@update', $question->id], 'files' => true]) !!}
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-4">
                            {!! Form::hidden('topic_id', $topic->id) !!}
                            <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                              {!! Form::label('question', 'Question') !!}
                              <span class="required">*</span>
                              {!! Form::textarea('question', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Question', 'rows'=>'8', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('question') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                                {!! Form::label('answer', 'Correct Answer') !!}
                                <span class="required">*</span>
                                {!! Form::select('answer', array('A'=>'A', 'B'=>'B', 'C'=>'C', 'D'=>'D'),null, ['class' => 'form-control select2', 'required' => 'required', 'placeholder'=>'']) !!}
                                <small class="text-danger">{{ $errors->first('answer') }}</small>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group{{ $errors->has('a') ? ' has-error' : '' }}">
                              {!! Form::label('a', 'A - Option') !!}
                              <span class="required">*</span>
                              {!! Form::text('a', null, ['class' => 'form-control', 'placeholder' => 'Please Enter A Option', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('a') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('b') ? ' has-error' : '' }}">
                              {!! Form::label('b', 'B - Option') !!}
                              <span class="required">*</span>
                              {!! Form::text('b', null, ['class' => 'form-control', 'placeholder' => 'Please Enter B Option', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('b') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('c') ? ' has-error' : '' }}">
                              {!! Form::label('c', 'C - Option') !!}
                              <span class="required">*</span>
                              {!! Form::text('c', null, ['class' => 'form-control', 'placeholder' => 'Please Enter C Option', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('c') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('d') ? ' has-error' : '' }}">
                              {!! Form::label('d', 'D - Option') !!}
                              <span class="required">*</span>
                              {!! Form::text('d', null, ['class' => 'form-control', 'placeholder' => 'Please Enter D Option', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('d') }}</small>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group{{ $errors->has('code_snippet') ? ' has-error' : '' }}">
                                {!! Form::label('code_snippet', 'Code Snippets') !!}
                                {!! Form::textarea('code_snippet', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Code Snippets', 'rows' => '5']) !!}
                                <small class="text-danger">{{ $errors->first('code_snippet') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('answer_ex') ? ' has-error' : '' }}">
                                {!! Form::label('answer_exp', 'Answer Explanation') !!}
                                {!! Form::textarea('answer_exp', null, ['class' => 'form-control',  'placeholder' => 'Please Enter Answer Explanation',  'rows' => '4']) !!}
                                <small class="text-danger">{{ $errors->first('answer_ex') }}</small>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="extras-block">
                              <h4 class="extras-heading">Images And Video For Question</h4>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group{{ $errors->has('question_video_link') ? ' has-error' : '' }}">
                                    {!! Form::label('question_video_link', 'Add Video To Question') !!}
                                    {!! Form::text('question_video_link', null, ['class' => 'form-control', 'placeholder'=>'https://myvideolink.com/embed/..']) !!}
                                    <small class="text-danger">{{ $errors->first('question_video_link') }}</small>
                                    <p class="help">YouTube And Vimeo Video Support (Only Embed Code Link)</p>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group{{ $errors->has('question_img') ? ' has-error' : '' }}">
                                    {!! Form::label('question_img', 'Add Image In Question') !!}
                                    {!! Form::file('question_img') !!}
                                    <small class="text-danger">{{ $errors->first('question_img') }}</small>
                                    <p class="help">Please Choose Only .JPG, .JPEG and .PNG</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <div class="btn-group pull-right">
                          {!! Form::submit("Update", ['class' => 'btn btn-wave']) !!}
                        </div>
                      </div>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>

  </div>
  @elseif($topic->test_type==2)
  <div class="box">
    <div class="box-body table-responsive">
      <table id="questions_table" class="table table-hover table-striped new">
        <thead>
          <tr>
            <th style="width: 60px;">Sr.No</th>
            <th>Questions</th>

            <th>A - Option</th>
            <th>B - Option</th>
            <th>C - Option</th>
            <th>D - Option</th>
            <th>Action</th>
            </tr>
          </thead>
          <tbody>
            
              @if($optionals)
              @foreach ($optionals as $key => $optional)
              <tr>
              <td>{{$optional->id}}</td>
              <td>{{$optional->question}}</td>
              <td>{{$optional->a}}</td>
              <td>{{$optional->b}}</td>
              <td>{{$optional->c}}</td>
              <td>{{$optional->d}}</td>
              <td>
                  <!-- Edit Button -->
                  <a type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#{{$optional->id}}EditModal" ><i class="fa fa-edit"></i> Edit</a>
                  <!-- Delete Button -->
                  <a type="button" class="btn btn-danger btn-xs " data-toggle="modal" data-target="#{{$optional->id}}deleteModal"><i class="fa fa-close"></i> Delete</a>
                  <div id="{{$optional->id}}deleteModal" class="delete-modal modal fade" role="dialog">
                    <!-- Delete Modal -->
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <div class="delete-icon"></div>
                        </div>
                        <div class="modal-body text-center">
                          <h4 class="modal-heading">Are You Sure ?</h4>
                          <p>Do you really want to delete these records? This process cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                          {!! Form::open(['method' => 'get', 'url' => ['admin/optional/multiple/delete', $optional->id]]) !!}
                            {!! Form::reset("No", ['class' => 'btn btn-gray', 'data-dismiss' => 'modal']) !!}
                            {!! Form::submit("Yes", ['class' => 'btn btn-danger']) !!}
                          {!! Form::close() !!}
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <div id="{{$optional->id}}EditModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Edit Question</h4>
                    </div>
                    {!! Form::model($optional, ['method' => 'post', 'url' => ['/admin/optinal/multiple/update', $optional->id], 'files' => true,'id'=>'optionalMultiplupdateForm']) !!}
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-4">
                            {!! Form::hidden('topic_id', $topic->id) !!}
                            <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                              {!! Form::label('question', 'Question') !!}
                              <span class="required">*</span>
                              {!! Form::textarea('question', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Question', 'rows'=>'8', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('question') }}</small>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group{{ $errors->has('a') ? ' has-error' : '' }}">
                              {!! Form::label('a', 'A - Option') !!}
                              <span class="required">*</span>
                              {!! Form::text('a', null, ['class' => 'form-control', 'placeholder' => 'Please Enter A Option', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('a') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('b') ? ' has-error' : '' }}">
                              {!! Form::label('b', 'B - Option') !!}
                              <span class="required">*</span>
                              {!! Form::text('b', null, ['class' => 'form-control', 'placeholder' => 'Please Enter B Option', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('b') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('c') ? ' has-error' : '' }}">
                              {!! Form::label('c', 'C - Option') !!}
                              <span class="required">*</span>
                              {!! Form::text('c', null, ['class' => 'form-control', 'placeholder' => 'Please Enter C Option', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('c') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('d') ? ' has-error' : '' }}">
                              {!! Form::label('d', 'D - Option') !!}
                              <span class="required">*</span>
                              {!! Form::text('d', null, ['class' => 'form-control', 'placeholder' => 'Please Enter D Option', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('d') }}</small>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group{{ $errors->has('d') ? ' has-error' : '' }}">
                              {!! Form::label('a_marks', 'A-Marks') !!}
                              <span class="required">*</span>
                              {!! Form::text('a_marks', null, ['class' => 'form-control', 'placeholder' => 'Please Enter D Option', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('d') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('d') ? ' has-error' : '' }}">
                              {!! Form::label('d', 'B-Marks') !!}
                              <span class="required">*</span>
                              {!! Form::text('b_marks', null, ['class' => 'form-control', 'placeholder' => 'Please Enter D Option', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('d') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('d') ? ' has-error' : '' }}">
                              {!! Form::label('d', 'C - Marks') !!}
                              <span class="required">*</span>
                              {!! Form::text('c_marks', null, ['class' => 'form-control', 'placeholder' => 'Please Enter D Option', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('d') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('d') ? ' has-error' : '' }}">
                              {!! Form::label('d', 'D - Marks') !!}
                              <span class="required">*</span>
                              {!! Form::text('d_marks', null, ['class' => 'form-control', 'placeholder' => 'Please Enter D Option', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('d') }}</small>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                      <div class="modal-footer">
                        <div class="btn-group pull-right">
                          {!! Form::submit("Update", ['class' => 'btn btn-wave']) !!}
                        </div>
                      </div>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
              @endforeach
              @endif
            
          </tbody>
        </table>
      </div>
    </div>
  @else
    <div class="box">
    <div class="box-body table-responsive">
      <table id="questions_table" class="table table-hover table-striped new">
        <thead>
          <tr>
            <th style="width: 60px;">Sr. No</th>
            <th>Questions</th>
            <th>Marks</th>
            <!-- <th>Images</th> -->
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @if ($descriptive)
            @foreach ($descriptive as $key => $descriptives)
             
              <tr>
                <td>
                  {{$key+1}}
                </td>
                <td>{{$descriptives->question}}</td>
                <td style="width: 100px;">{{$descriptives->marks}}</td>
                <!-- <td><img src="{{asset('/images/questions/'.$descriptives->question_img)}}" class="img-responsive" alt="image" width="80"></td>              -->
                <td>
                  <!-- Edit Button -->
                  <a type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#{{$descriptives->id}}EditModal"><i class="fa fa-edit"></i> Edit</a>
                  <!-- Delete Button -->
                  <a type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#{{$descriptives->id}}deleteModal"><i class="fa fa-close"></i> Delete</a>
                  <div id="{{$descriptives->id}}deleteModal" class="delete-modal modal fade" role="dialog">
                    <!-- Delete Modal -->
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <div class="delete-icon"></div>
                        </div>
                        <div class="modal-body text-center">
                          <h4 class="modal-heading">Are You Sure ?</h4>
                          <p>Do you really want to delete these records? This process cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                          {!! Form::open(['method' => 'get', 'url' => ['admin/descriptive/questions/destroy', $descriptives->id]]) !!}
                            {!! Form::reset("No", ['class' => 'btn btn-gray', 'data-dismiss' => 'modal']) !!}
                            {!! Form::submit("Yes", ['class' => 'btn btn-danger']) !!}
                          {!! Form::close() !!}
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <!-- edit model -->
              <div id="{{$descriptives->id}}EditModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Edit Question</h4>
                    </div>
                    {!! Form::model($descriptives, ['method' => 'post', 'url' => ['admin/descriptive/questions/update', $descriptives->id], 'files' => true]) !!}
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-4">
                            {!! Form::hidden('topic_id', $topic->id) !!}
                            <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                              {!! Form::label('question', 'Question') !!}
                              <span class="required">*</span>
                              {!! Form::textarea('question', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Question', 'rows'=>'8', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('question') }}</small>
                            </div>
                            <div class="form-group{{ $errors->has('marks') ? ' has-error' : '' }}">
                                {!! Form::label('marks', 'Marks') !!}
                                   <span class="required">*</span>
                              {!! Form::text('marks', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Question', 'rows'=>'8', 'required' => 'required']) !!}
                              <small class="text-danger">{{ $errors->first('marks') }}</small>
                                <small class="text-danger">{{ $errors->first('question') }}</small>
                            </div>
                          </div>
                          
                          <div class="col-md-12">
                            <div class="extras-block">
                              <h4 class="extras-heading">Images And Video For Question</h4>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group{{ $errors->has('question_img') ? ' has-error' : '' }}">
                                    {!! Form::label('question_img', 'Add Image In Question') !!}
                                    {!! Form::file('question_img') !!}
                                    <small class="text-danger">{{ $errors->first('question_img') }}</small>
                                    <p class="help">Please Choose Only .JPG, .JPEG and .PNG</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <div class="btn-group pull-right">
                          {!! Form::submit("Update", ['class' => 'btn btn-wave']) !!}
                        </div>
                      </div>
                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>

  </div>
  @endif
@endsection

