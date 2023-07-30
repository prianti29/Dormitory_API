@extends('layouts.app')
@section('contents')
<a href="{{ url('/api/account/create') }}" class="btn btn-success" style="margin-top: 10px">Add Deposit</a>
<a href="{{ url('/api/perHead-deposit-view') }}" class="btn btn-success" style="margin-top: 10px">Accounts Details</a>

<table class="table tables-content">
    <tr>
        <th>Member id</th>
        <th>Deposit</th>
        <th>Action</th>
    </tr>
    @foreach ($account_list as $item)
    <tr>
        <td>{{ $item->member_id }}</td>
        <td>{{ $item->deposit_cost }}</td>
        <td>
            <a href="{{ url("/api/account/$item->id/edit") }}" class="btn btn-warning btn-sm action-btn">Update</a>
            <form action="{{ url("/api/account/$item->id") }}" method="POST"
                onsubmit="return confirm('Do you really want to delete this category?');" class="action-btn">
                @csrf
                @method('delete')
                <input type="submit" value="Delete" class="btn btn-danger btn-sm">
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
