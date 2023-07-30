@extends('layouts.app')
@section('contents')
<h2 style="color: aliceblue">Total Deposit balance: {{ $totalDeposit }}</h2>
<hr>
<table class="table tables-content" style="width: 700px">
    <tr>
        <th>Member id</th>
        <th>Individual Accounts Deposit</th>
    </tr>
    @foreach ($individualDepositData as $item)
    <tr>
        <td>{{ $item->member_id }}</td>
        <td>{{ $item->total_deposit  }}</td>
    </tr>
    @endforeach
