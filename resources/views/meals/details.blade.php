@extends('layouts.app')
@section('contents')
<form class="form-horizontal" action="{{ url('/api/monthly-count') }}" method="GET">
    @csrf
    <div class="form-group create-form">
        <label class="control-label col-sm-2">Start Date:</label>
        <div class="col-sm-10">
            <input type="date" name="start_date" class="form-control" style="width: 20pc" value=""
                placeholder="Enter Date from">
        </div>
        <label class="control-label col-sm-2">End Date:</label>
        <div class="col-sm-10">
            <input type="date" name="end_date" class="form-control" style="width: 20pc" value="" placeholder="Enter Date to">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class=" btn btn-success">Enter</button>
        </div>
    </div>
</form>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@endsection
