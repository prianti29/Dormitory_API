@extends('layouts.app')
@section('contents')
<a href="{{ url('/api/cost/create') }}" class="btn btn-success" style="margin-top: 10px">Add cost</a>
<a href="{{ url('/api/monthly-cost-view') }}" class="btn btn-success" style="margin-top: 10px">Cost Details</a>
<table class="table tables-content">
    <tr>
        <th>Member id</th>
        <th>Types of cost</th>
        <th>Costing Amount</th>
        <th>Action</th>
    </tr>
    @foreach ($cost_list as $item)
    <tr>
        <td>{{ $item->member_id }}</td>
        <td>{{ $item->types_of_cost }}</td>
        <td>{{ $item->cost_amount }}</td>
        <td>
            <a href="{{ url("/api/cost/$item->id/edit") }}" class="btn btn-warning btn-sm action-btn">Update</a>
            <form action="{{ url("/api/cost/$item->id") }}" method="POST"
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
