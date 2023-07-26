@extends('layouts.app')
@section('contents')
<a href="{{ url('/api/meal/create') }}" class="btn btn-success" style="margin-top: 10px">Add meal</a>
<a href="{{ url('/api/monthly-count-view') }}" class="btn btn-success" style="margin-top: 10px">meals Details</a>
<hr>
<table class="table tables-content">
<tr>
    <th>member id</th>
    <th>Daily Count</th>
    <th>Action</th>
</tr>
@foreach ($meal_list as $item)
<tr>
    <td>{{ $item->member_id }}</td>
    <td>{{ $item->daily_count }}</td>
    <td>
        <a href="{{ url("/api/meal/$item->id/edit") }}" class="btn btn-warning btn-sm action-btn">Update</a>
        <form action="{{ url("/api/meal/$item->id") }}" method="POST"
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
