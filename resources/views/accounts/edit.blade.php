@extends('layouts.app')
@section('contents')

<h3 style="color: aliceblue">Edit Deposit amount</h3>


<form class="form-horizontal create-form" action="{{ url("/api/account/$account->id") }}" method="POST">
    @method("put")
    @csrf
    <label class="control-label col-sm-2">Deposit amount:</label>
    <div class="col-sm-10">
        <input type="text" name="deposit_cost" class="form-control" value="{{ $account->deposit_cost }}"
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
