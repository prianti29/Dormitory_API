@extends('layouts.app')
@section('contents')

<h3 style="color: aliceblue">Edit meals count</h3>
<hr>

<form class="form-horizontal create-form" action="{{ url("/api/cost/$cost->id") }}" method="POST">
    @method("put")
    @csrf
    <label class="control-label col-sm-2">Types of cost:</label>
    <div class="col-sm-10">
        <input type="text" name="daily_count" class="form-control" value="{{ $cost->types_of_cost }}"
            placeholder=" Enter daily count">
    </div>
    <label class="control-label col-sm-2">Cost amount:</label>
    <div class="col-sm-10">
        <input type="text" name="cost_amount" class="form-control" value="{{ $cost->cost_amount }}"
            placeholder=" Enter daily count">
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10" style="margin:10px 0px 0px 205px ">
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
