@extends('layouts.app')
@section('contents')
<h2 style="color: aliceblue">total Meal:  {{ $total_meal }}</h2>

<table class="table tables-content">
    <tr>
        <th>member id</th>
        <th>individual Meal</th>
    </tr>
    @foreach ($individual_meals as $item)
    <tr>
        <td>{{ $item->member_id }}</td>
        <td>{{ $item->total_meal }}</td>

    </tr>
    @endforeach

@endsection
