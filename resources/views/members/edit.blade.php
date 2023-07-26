@extends('layouts.app')
@section('contents')

<h3 style="color: aliceblue">Edit members Detail</h3>
<hr>

<form class="form-horizontal" action="{{ url("/api/member/$member->id") }}" method="POST">
    @method("put");
    @csrf
    <div class="form-group create-form">
        <label class="control-label col-sm-2">Member name:</label>
        <div class="col-sm-10">
            <input type="text" name="member_name" class="form-control" value="{{ $member->member_name }}"
                placeholder="Enter Member Name">
        </div>
        <label class="control-label col-sm-2">Member Type:</label>
        <div class="col-sm-10">
            <input type="text" name="member_type" class="form-control" value="{{ $member->member_type }}"
                placeholder="Enter Member type">
        </div>
        <label class="control-label col-sm-2">Phone:</label>
        <div class="col-sm-10">
            <input type="text" name="phone" class="form-control" value="{{ $member->phone }}"
                placeholder="Enter phone number">
        </div>
        <label class="control-label col-sm-2">Email:</label>
        <div class="col-sm-10">
            <input type="text" name="email" class="form-control" value="{{ $member->email }}" placeholder="Enter email">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
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
