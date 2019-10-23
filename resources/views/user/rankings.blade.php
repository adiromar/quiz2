@extends('layouts.main')

@section('content')

    <div class="breadcrumb mb-4">
      <small style="font-weight:bold;font-size:14px">
        Check out Point Rankings of online tests.
      </small>
    </div>

    <div class="col-md-12">

      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th width="80">Rank</th>
            <th width="400">User</th>
            <!-- <th>Attempts</th> -->
            <th>Correct Answers</th>
            <th>Time Taken</th>
            <th>%</th>

          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          @foreach($data as $uid => $dat)

          @if( $dat['total'] != 0 )
          <tr>
            <td>{{ $i }}</td>
            <td>{{ $dat['name'] }}</td>
            <!-- <td>{{ $dat['total'] }}</td> -->
            <td>{{ $dat['correct'] }}</td>
            <td>{{ $dat['timetaken'] }}</td>
            <td>{{
              round( $dat['ratio'], 2 )
            }}</td>

          </tr>
          <?php $i++; ?>
          @endif
          @endforeach
        </tbody>
      </table>

    </div>

@endsection
