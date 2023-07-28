@extends('layouts.app')
@section('contents')
<h2 style="color: aliceblue">Total Meal:  {{ $total_meal }}</h2>

<table class="table tables-content">
    <tr>
        <th>Member id</th>
        <th>Individual Meal</th>
    </tr>
    @foreach ($individual_meals as $item)
    <tr>
        <td>{{ $item->member_id }}</td>
        <td>{{ $item->total_meal }}</td>
    </tr>
    @endforeach
@endsection
