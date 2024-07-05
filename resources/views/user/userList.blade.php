@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-5">
    <h1>User List</h1>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($users->count() > 0) 
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Group</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->group }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
<td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->links() }} 
    @else
        <p>No users found.</p>
    @endif
</div>
@endsection
