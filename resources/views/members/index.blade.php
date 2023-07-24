@extends('layouts.app')
@section('contents')
<a href="{{ url('/api/member/create') }}" class="btn btn-success" style="margin-top: 10px">Add new Member</a>
<hr>
<table class="table table-bordered tables-content">
    <tr>
        <th>Member name</th>
        <th>Member Type</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
   
    @foreach ($member_list as $item)
    <tr>
        <td>{{ $item->member_name }}</td>
        <td>{{ $item->member_type }}</td>
        <td>{{ $item->phone}}</td>
        <td>{{ $item->email}}</td>
        <td>
            <a href="{{ url("/api/member/$item->id/edit") }}" class="btn btn-warning btn-sm">Update</a>
            <form action="{{ url("/api/member/$item->id") }}" method="POST"
                onsubmit="return confirm('Do you really want to delete this category?');">
                @csrf
                @method('delete')
                <input type="submit" value="Delete" class="btn btn-danger btn-sm">
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection
