@extends('layouts.app')
@section('contents')

<h3 style="color: aliceblue">Create Deposit</h3>
<hr>
<form class="form-horizontal" action="{{ url('/api/account') }}" method="POST">
    @csrf
    <div class="form-group create-form">
        <select class="form-control top-down-menu" name="member_id" >
            <option>Select member</option>
            @foreach ($member_list as $value)
            <option value="{{ $value->id}}">
                {{ $value->member_name }}
            </option>
            @endforeach
        </select>
        <label class="control-label col-sm-2">Deposit:</label>
        <div class="col-sm-10">
            <input type="text" name="deposit_cost" class="form-control" value="" placeholder="Enter amount of cost">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-success">create</button>
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
