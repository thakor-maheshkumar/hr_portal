@extends('layouts.admin', [
  'page_header' => 'Assign Test to Candidate',
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
      <!-- Button trigger modal -->
      <div class="margin-bottom">
      <a href="{{ route('usertopics.add') }}" class="btn btn-md btn-primary">+ Assign Test to Candidate</a>
        
      </div>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>SN</th>
            <th>Candidate Name</th>
            <th>Assiged Test list</th>
            <th><i class="fa fa-trash" aria-hidden="true"></i></th>
          </tr>
        </thead>

        <tbody>

          <?php $i=0;?>
          @foreach ($usertopicss as $usertopics)
            <?php $i++; ?>
            <tr>
              <td><?php echo $i;?></td>
              <td>{{ $usertopics->name }}</td>
              <td>{{$usertopics->title}}</td>
              <td>
                <form method="POST" action="{{ route('usertopics.delete',$usertopics->user_id) }}">
                  {{ method_field('DELETE') }}
                  {{ csrf_field() }}
                  <button onclick="return confirm('DELETE this row?')" type="submit" class="btn btn-sm btn-danger">
                    <i class="fa fa-trash-o"></i>
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
