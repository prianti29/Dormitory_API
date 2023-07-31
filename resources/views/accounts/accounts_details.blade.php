@extends('layouts.app')
@section('contents')
<h2 style="color: aliceblue">Total Deposit balance: {{ $totalDeposit }}</h2>

<table class="table tables-content" style="width: 500px; text-align: center">
    <tr >
        <th style="text-align: center">Member id</th>
        <th style="text-align: center">Individual Accounts Deposit</th>
    </tr>
    @foreach ($individualDepositData as $item)
    <tr>
        <td>{{ $item->member_id }}</td>
        <td>{{ $item->total_deposit  }}</td>
    </tr>
    @endforeach
    @endsection
