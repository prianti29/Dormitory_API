@extends('layouts.app')

@section('contents')
<div class="user-content">
    <div class="user-details">
        <h1>hello {{ Auth::user()->email }}</h1>
    </div>
    <div class="dashboard">
        <h1>Welcome to Dormentory management</h1>
    </div>
</div>
@endsection
