@extends('layouts.admin', [
  'page_header' => 'Candidates',
  'dash' => '',
  'quiz' => '',
  'users' => 'active',
  'questions' => '',
  'top_re' => '',
  'all_re' => '',
  'sett' => '',
  'user_re' => '',
  'descriptivescroing' => ''
])

<style type="text/css">
.BirthdayDatePicker .ui-datepicker-year
{
 display:none;   
}
</style>
@section('content')
@include('message')
  @if ($auth->role == 'A')
    <div class="margin-bottom">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">Add Candidate</button>
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#AllDeleteModal">Delete All Candidates</button>
    </div>
    <!-- All Delete Button -->
    <div id="AllDeleteModal" class="delete-modal modal fade" role="dialog">
      <!-- All Delete Modal -->
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div class="delete-icon"></div>
          </div>
          <div class="modal-body text-center">
            <h4 class="modal-heading">Are You Sure ?</h4>
            <p>Do you really want to delete "All these records"? This process cannot be undone.</p>
          </div>
          <div class="modal-footer">
            {!! Form::open(['method' => 'POST', 'action' => 'DestroyAllController@AllUsersDestroy']) !!}
                {!! Form::reset("No", ['class' => 'btn btn-gray', 'data-dismiss' => 'modal']) !!}
                {!! Form::submit("Yes", ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
    <!-- Create Modal -->
    <div id="createModal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Candidate</h4>
          </div>
          {!! Form::open(['method' => 'POST', 'enctype'=>'multipart/form-data','action' => 'UsersController@store','id'=>'userform']) !!}
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {!! Form::label('name', 'Candidate Name') !!}
                    <span class="required">*</span>
                    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Name']) !!}
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                  </div>
                  @if ($errors->has('name'))
                  <span class="error">{{ $errors->first('name') }}</span>
                @endif
                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    {!! Form::label('email', 'Email address') !!}
                    <span class="required">*</span>
                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Please enter email ID', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('email') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    {!! Form::label('password', 'Password') !!}
                    <span class="required">*</span>
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder'=>'Enter Your Password', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('password') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                      {!! Form::label('role', 'User Role') !!}
                      <span class="required">*</span>
                      {!! Form::select('role', ['S' => 'Candidate', 'A'=>'Administrator'], null, ['class' => 'form-control select2', 'required' => 'required']) !!}
                      <small class="text-danger">{{ $errors->first('role') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('expectedctc') ? ' has-error' : '' }}">
                      <label for="expectedctc" id="expectedctclable">Expected Salary (Per Annum):</label>
                      <select name="currency" class="form-control" required="required" id="currency">
                        <option value="INR">INR</option>
                        <option value="GBP">GBP</option>
                        <option value="USD">USD</option>
                        <option value="AED">AED</option>
                        <option value="AUD">AUD</option>
                      </select>
                      <input type="number" name="expectedctc" id="expectedctc" class="form-control input-sm" placeholder="Please Enter Expected Salary (Per Annum)" min="0" oninput="validity.valid||(value='');" required="required">
                      <small class="text-danger">{{ $errors->first('expectedctc') }}</small>
                  </div>
            
                   <div class="form-group{{ $errors->has('noticeperiod') ? ' has-error' : '' }}" style="margin-top: 85px">
                      <label for="noticeperiod">Notice Period (Days):</label>
                      <input type="number" name="noticeperiod" id="noticeperiod" class="form-control input-sm" placeholder="Please enter notice period (Days)" required="required"
                      min="0" oninput="validity.valid||(value='');">
                      <small class="text-danger">{{ $errors->first('noticeperiod') }}</small>
                    </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                    {!! Form::label('mobile', 'Mobile No.') !!}
                    <span class="required">*</span>
                    {!! Form::number('mobile', null, ['class' => 'form-control', 'placeholder' => 'eg: +91-123-456-7890', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('mobile') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                    {!! Form::label('city', 'Enter City') !!}
                    {!! Form::text('city', null, ['class' => 'form-control', 'placeholder'=>'Enter Your City']) !!}
                    <small class="text-danger">{{ $errors->first('city') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                    {!! Form::label('address', 'Address') !!}
                    {!! Form::textarea('address', null, ['class' => 'form-control', 'rows'=>'4', 'placeholder' => 'Enter Your address']) !!}
                    <small class="text-danger">{{ $errors->first('address') }}</small>
                  </div>
                   <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                      <label for="date">Date:</label>
                      <input type="text" id="date" name="date" class="form-control input-sm" placeholder="Please Enter Date(MM/DD/YYYY)" value="{{date('m/d/Y')}}" required="required" autocomplete="off">
                      <small class="text-danger">{{ $errors->first('date') }}</small>
                    </div>
                  <div class="form-group{{ $errors->has('positionapplied') ? ' has-error' : '' }}">
                    <label for="positionapplied">Position applied for:</label>
                    <input type="text" name="positionapplied" id="positionapplied" class="form-control input-sm" placeholder="Please enter position applied for" required="required">
                    <small class="text-danger">{{ $errors->first('positionapplied') }}</small>
                  </div>
                  <div class="form-group">
                    
                      <label class="radio-inline-text">Negotiable:</label>
                      <input type="radio" name="expectednegotiable" value="1" required="required" style="margin-left: 15px"> Yes
                    
                      <input type="radio" name="expectednegotiable" value="0" required="required" style="margin-left: 20px"> No
                  </div>
                  <div class="form-group">
                      <label class="radio-inline-text">Negotiable:</label>
                      <input type="radio" name="noticenegotiable" value="1" required="required" style="margin-left: 15px"> Yes
                      <input type="radio" name="noticenegotiable" value="0" required="required" style="margin-left: 20px"> No
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
                    <label for="employmentdesired">Employment Desired:</label>
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
                    <label for="nightshift">Are you open to working in a night shift?</label>
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
                    <label for="appliedposition">Have you applied for any position at The Annet Group in the last 6 months / worked with The Annet Group? </label>
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
                    <label for="jobopportunity">How did you come to know about this job opportunity? </label>
                      <label class="checkbox-inline">
                        <input type="checkbox" name="jobopportunity[]" value="Call from HR">Call from HR
                      </label>
                      <label class="checkbox-inline">
                        <input type="checkbox" name="jobopportunity[]" value="Consultant">Consultant
                      </label>
                      <label class="checkbox-inline">
                      <input type="checkbox" name="jobopportunity[]" value="Posting on job">Posting on the job portal
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
                      <label for="resume">Upload Resume</label>
                      <input type="file" name="resume" placeholder="please upload your resume" required="required">
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
    <div class="content-block box">
      <div class="box-body table-responsive">
        <table id="example1" class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Candidate Name</th>
              <th>Email</th>
              <th>Mobile No.</th>
              <th>City</th>
              <th>Address</th>
              <th>User Role</th>
              <th>Resume</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @if ($users)
              @php($n = 1)
              @foreach ($users as $key => $user)
                <tr>
                  <td>
                    {{$n}}
                    @php($n++)
                  </td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->mobile}}</td>
                  <td>{{$user->city}}</td>
                  <td>{{$user->address}}</td>
                  <td>{{$user->role == 'S' ? 'Candidate' : '-'}}</td>
                  <td><a href='{{url("download/{$user->resume}")}}'>@if(!empty($user->resume))Download Resume @endif</a></td>
                  <td>
                    <!-- Edit Button -->
                    <a type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#{{$user->id}}EditModal"><i class="fa fa-edit"></i> Edit</a>
                    <!-- Delete Button -->
                    <a type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#{{$user->id}}deleteModal"><i class="fa fa-close"></i> Delete</a>
                    <div id="{{$user->id}}deleteModal" class="delete-modal modal fade" role="dialog">
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
                            {!! Form::open(['method' => 'DELETE', 'action' => ['UsersController@destroy', $user->id]]) !!}
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
                <div id="{{$user->id}}EditModal" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Candidate </h4>
                      </div>
                      {!! Form::model($user, ['method' => 'PATCH','enctype'=>'multipart/form-data','action' => ['UsersController@update', $user->id,]]) !!}
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                {!! Form::label('name', 'Name') !!}
                                <span class="required">*</span>
                                {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Name']) !!}
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                              </div>
                              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                {!! Form::label('email', 'Email address') !!}
                                <span class="required">*</span>
                                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Please enter email ID', 'required' => 'required']) !!}
                                <small class="text-danger">{{ $errors->first('email') }}</small>
                              </div>
                              {{-- <label for="">Change Password: </label>
                              <input type="checkbox" name="changepass"> --}}
                              {{-- <input type="radio" value="1" name="changepass" id="ch1">&nbsp;Yes
                               <input type="radio" value="0" name="changepass" checked id="ch2">&nbsp;No --}}
                               <br>
                              <div id="pass" class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                {!! Form::label('password', 'Password') !!}
                                <span class="required">*</span>
                               
                                <input class="form-control" type="password" value="{{$user->password}}" placeholder="Enter new password" name="password" >
                                <small class="text-danger">{{ $errors->first('password') }}</small>
                              </div>

                              <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                                  {!! Form::label('role', 'User Role') !!}
                                  
                                  {!! Form::select('role', ['S' => 'Candidate', 'A'=>'Administrator'], null, ['class' => 'form-control select2', 'required' => 'required']) !!}
                                  <small class="text-danger">{{ $errors->first('role') }}</small>
                              </div>
                              <div class="form-group{{ $errors->has('expectedctc') ? ' has-error' : '' }}">
                                  <label for="expectedctc" id="expectedctclable">Expected Salary (Per Annum):</label>
                                   <select name="currency" class="form-control" required="required" id="currency">
                                    <option value="INR" {{ $user->currency == 'INR' ? 'selected' : '' }}>INR</option>
                                    <option value="GBP" {{ $user->currency == 'GBP' ? 'selected' : '' }}>GBP</option>
                                    <option value="USD" {{ $user->currency == 'USD' ? 'selected' : '' }}>USD</option>
                                    <option value="AED" {{ $user->currency == 'AED' ? 'selected' : '' }}>AED</option>
                                    <option value="AUD" {{ $user->currency == 'AUD' ? 'selected' : '' }}>AUD</option>
                                  </select>
                                  <input type="number" name="expectedctc" id="expectedctc" class="form-control input-sm" value="{{$user->expectedctc}}" placeholder="Please Enter Expected Salary (Per Annum)" required="required">
                                  <small class="text-danger">{{ $errors->first('expectedctc') }}</small>
                              </div>
                               <div class="form-group{{ $errors->has('noticeperiod') ? ' has-error' : '' }}" style="margin-top: 85px">
                                  <label for="noticeperiod">Notice Period (Days):</label>
                                  <input type="number" name="noticeperiod" id="noticeperiod" class="form-control input-sm" value="{{$user->noticeperiod}}" placeholder="Please enter notice period" required="required">
                                  <small class="text-danger">{{ $errors->first('noticeperiod') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                                {!! Form::label('mobile', 'Mobile No.') !!}
                                
                                {!! Form::text('mobile', null, ['class' => 'form-control', 'placeholder' => 'eg: +91-123-456-7890']) !!}
                                <small class="text-danger">{{ $errors->first('mobile') }}</small>
                              </div>
                              <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                {!! Form::label('city', 'Enter City') !!}
                                {!! Form::text('city', null, ['class' => 'form-control', 'placeholder'=>'Enter Your City']) !!}
                                <small class="text-danger">{{ $errors->first('city') }}</small>
                              </div>
                              <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                {!! Form::label('address', 'Address') !!}
                                {!! Form::textarea('address', null, ['class' => 'form-control', 'rows'=>'5', 'placeholder' => 'Enter Your Address']) !!}
                                <small class="text-danger">{{ $errors->first('address') }}</small>
                              </div>
                              <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                                  <label for="date">Date:</label>
                                  <input type="text" id="date" name="date" class="form-control input-sm" placeholder="Please Enter Date(MM/DD/YYYY)" 
                                  value="{{$user->date}}" required="required" autocomplete="off">
                                  <small class="text-danger">{{ $errors->first('date') }}</small>
                                </div>
                              <div class="form-group{{ $errors->has('positionapplied') ? ' has-error' : '' }}">
                                <label for="positionapplied">Position applied for:</label>
                                <input type="text" name="positionapplied" id="positionapplied" class="form-control input-sm" value="{{$user->positionapplied}}" placeholder="Please enter position applied for" required="required">
                                <small class="text-danger">{{ $errors->first('positionapplied') }}</small>
                              </div>
                              <div class="form-group">
                                <label class="radio-inline-text">Negotiable:</label>
                                  <input type="radio" name="expectednegotiable" style="margin-left: 15px" @if($user->expectednegotiable == '1') {{ "checked" }}@endif value="1" required="required">Yes
                                  
                                  <input type="radio" name="expectednegotiable" style="margin-left: 20px" @if($user->expectednegotiable == '0') {{ "checked" }}@endif value="0" required="required" >No
                                
                              </div>
                              <div class="form-group">
                                  <label class="radio-inline-text">Negotiable:</label>
                                  <input type="radio" name="noticenegotiable" style="margin-left: 15px" @if($user->noticenegotiable == '1') {{ "checked" }}@endif value="1" required="required">Yes
                                  <input type="radio" name="noticenegotiable" style="margin-left: 20px" @if($user->noticenegotiable == '0') {{ "checked" }}@endif value="0" required="required">No
                                
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                              <div class="form-group{{ $errors->has('reasonforjobchange') ? ' has-error' : '' }}">
                                <label for="reasonforjobchange">Reason for Job Change:</label>
                                <textarea placeholder="Please enter reason for job change" name="reasonforjobchange" cols="50" rows="1" id="reasonforjobchange" class="form-control" required="required">{{$user->reasonforjobchange}}</textarea>
                                <small class="text-danger">{{ $errors->first('reasonforjobchange') }}</small>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-xs-9 col-sm-9 col-md-9">
                              <div class="form-group">
                              <label for="employmentdesired">Employment Desired:</label>
                                <label class="checkbox-inline">
                                  <input type="radio" name="employmentdesired" @if($user->employmentdesired == 'Full-time only') {{ "checked" }}@endif value="Full-time only" required="required">Full-time only
                                </label>
                                <label class="checkbox-inline">
                                  <input type="radio" name="employmentdesired" @if($user->employmentdesired == 'Part-time only') {{ "checked" }}@endif value="Part-time only" required="required">Part-time only
                                </label>
                                <label class="checkbox-inline">
                                  <input type="radio" name="employmentdesired" @if($user->employmentdesired == 'Full or part-time') {{ "checked" }}@endif value="Full or part-time" required="required">Full or part-time
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-xs-9 col-sm-9 col-md-9">
                              <div class="form-group">
                              <label for="nightshift">Are you open to working in a night shift?</label>
                                <label class="checkbox-inline">
                                  <input type="radio" name="nightshift" @if($user->nightshift == '1') {{ "checked" }}@endif value="1" required="required">Yes
                                </label>
                                <label class="checkbox-inline">
                                  <input type="radio" name="nightshift" @if($user->nightshift == '0') {{ "checked" }}@endif value="0" required="required">No
                                </label>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                              <div class="form-group">
                              <label for="appliedposition">Have you applied for any position at The Annet Group in the last 6 months / worked with The Annet Group? </label>
                                <label class="checkbox-inline">
                                  <input type="radio" name="appliedposition" @if($user->appliedposition == '1') {{ "checked" }}@endif value="1" required="required">Yes
                                </label>
                                <label class="checkbox-inline">
                                  <input type="radio" name="appliedposition" @if($user->appliedposition == '0') {{ "checked" }}@endif value="0" required="required">No
                                </label>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-xs-9 col-sm-9 col-md-9">
                              <div class="form-group{{ $errors->has('reasonforjobchange') ? ' has-error' : '' }}">
                              <label for="jobopportunity">How did you come to know about this job opportunity? </label>
                              <?php $jobopportunity = explode(',', $user->jobopportunity);?>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="jobopportunity[]" @if(in_array("Call from HR", $jobopportunity)) {{ "checked" }}@endif value="Call from HR">Call from HR
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="jobopportunity[]" @if(in_array("Consultant", $jobopportunity)) {{ "checked" }}@endif value="Consultant">Consultant
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="jobopportunity[]" @if(in_array("Posting on the job portal", $jobopportunity)) {{ "checked" }}@endif value="Posting on the job portal">Posting on the job portal
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="jobopportunity[]" @if(in_array("Company Website", $jobopportunity)) {{ "checked" }}@endif value="Company Website">Company Website
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="jobopportunity[]" @if(in_array("Employee reference", $jobopportunity)) {{ "checked" }}@endif value="Employee reference">Employee reference
                                </label>
                                <label class="checkbox-inline">
                                  <input type="checkbox" name="others" @if(!empty($user->others)) checked @endif value="Others">Others
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                          <div class="col-xs-3 col-sm-3 col-md-3">
                          <textarea class="form-control jobopportunity" name="others" cols="25" rows="1" placeholder="Please Enter Other Job Opportunity" 
                          @if(empty($user->others))style="display: none;" @endif>{{$user->others}}</textarea>
                        </div>
                        </div>

                          <!-- <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3">
                              <div class="form-group{{ $errors->has('reference') ? ' has-error' : '' }}">
                                <label for="reference">Employee Reference(If any)</label>
                                <textarea placeholder="Please Enter Employee Reference" name="reference" cols="25" rows="1" id="reference" class="form-control" required="required">{{$user->reference}}</textarea>
                                <small class="text-danger">{{ $errors->first('reference') }}</small>
                              </div>
                            </div>
                          </div> -->
                          <div class="row">
                            <div class="col-xs-3 col-sm-3 col-md-3">
                               <div class="form-group{{ $errors->has('resume') ? ' has-error' : '' }}">
                                 <label for="resume">Upload Resume</label>
                                 
                                 <input type="file" name="resume" value="{{$user->resume}}">@if (pathinfo($user->resume, PATHINFO_EXTENSION) == 'pdf')<i class="fa fa-file-pdf-o" aria-hidden="true"></i>@endif @if(pathinfo($user->resume, PATHINFO_EXTENSION) == 'doc' || pathinfo($user->resume, PATHINFO_EXTENSION) == 'docx') <i class="fa fa-file-word-o" aria-hidden="true"></i>@endif<i class="fas fa-file-word"></i>{{$user->resume}}
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
@section('scripts')


<script>
  $(document).ready(function(){
    $('input[name=others').click(function(){
      if(this.checked){
        $('.jobopportunity').show()
      }else{
        $('.jobopportunity').hide();
      }
    })
  })
</script>
@endsection
