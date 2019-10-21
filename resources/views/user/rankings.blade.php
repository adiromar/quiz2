@extends('layouts.main')

@section('content')

    <div class="breadcrumb mb-4">
      <small style="font-weight:bold;font-size:14px">
        Check out Rankings of online tests.
      </small>
    </div>

    <div class="col-md-12">

      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <!-- <th width="100">Rank</th> -->
            <th>User</th>
            <th>Attempts</th>
            <th>Average Points</th>
            <th></th>
          </tr>
        </thead>
        <tbody>

          @foreach($data as $uid => $dat)
          @if( $dat['total'] != 0 )
          <tr>
            <!-- <td></td> -->
            <td>{{ $dat['name'] }}</td>
            <td>{{ $dat['total'] }}</td>
            <td>{{ $dat['correct'] }}</td>
            <td>{{
              round( $dat['correct'] / $dat['total'] * 100, 2 )
            }}</td>
          </tr>
          @endif
          @endforeach
        </tbody>
      </table>

    </div>

@endsection
