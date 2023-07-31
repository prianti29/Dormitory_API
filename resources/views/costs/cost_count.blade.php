@extends('layouts.app')
@section('contents')
<h2 style="color: aliceblue">Total cost: {{ $total_cost}}</h2>
<h2 style="color: aliceblue">Per Meal Rate:  {{ $per_meal_rate }}</h2>
<hr>
<table class="table tables-content" style="width: 700px; text-align: center">
    <tr>
        <th style="text-align: center">Member id</th>
        <th style="text-align: center">Individual market cost</th>
        <th style="text-align: center">Individual meal cost</th>
        <th style="text-align: center">Meal Debit/Credit</th>
    </tr>
    @foreach ($individual_cost as $item)
    @php
                $memberId = $item->member_id;
                $individual_meal = $individual_meal_cost[$memberId] ?? 0;
                $devitCreditVal = $debitCredit[$memberId] ?? 0;
    @endphp
    <tr>
        <td>{{ $memberId }}</td>
        <td>{{ $item->total_cost }}</td>
        <td>{{ $individual_meal }}</td>
        <td>
            @if($devitCreditVal > 0)
                <span style="color: rgb(24, 226, 24);">+{{ $devitCreditVal }}</span>
            @elseif($devitCreditVal < 0)
                <span style="color: red;">{{ $devitCreditVal }}</span>
            @elseif($devitCreditVal == 0)
            <span style="color: red;">-{{ $individual_meal }}</span>
            @endif
        </td>
    </tr>
    @endforeach
    @endsection
