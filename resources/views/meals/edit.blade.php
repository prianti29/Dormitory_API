@extends('layouts.app')
@section('contents')

<h3 style="color: aliceblue">Edit meals count</h3>
<hr>

<form class="form-horizontal create-form" action="{{ url("/api/meal/$meal->id") }}" method="POST">
    @method("put")
    @csrf
    {{-- <select class="form-control" name="member_id" value="">
        <option>Select member</option>
        @foreach ($member_list as $value)
        <option value="{{ $value->id}}">
            {{ $value->member_name }}
        </option>
        @endforeach
    </select> --}}
    <label class="control-label col-sm-2">Daily Count:</label>
    <div class="col-sm-10">
        <input type="text" name="daily_count" class="form-control" value="{{ $meal->meal_count }}"
            placeholder=" Enter daily count">
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10" style="margin:5px 0px 0px 170px ">
            <button type="submit" class="btn btn-success">Update</button>
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
