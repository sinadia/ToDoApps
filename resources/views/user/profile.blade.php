@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container mt-5">
        @if (Auth::check())
            <h1>Profilku</h1>
            
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <h3>Current Profile Information</h3>

            <div class="mb-3">
                <label class="form-label">Name:</label>
                <p>{{ Auth::user()->name }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label">Email:</label>
                <p>{{ Auth::user()->email }}</p>
            </div>
            
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateProfileModal">
                Update Profile Information
            </button>

            <div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateProfileModalLabel">Update Profile</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/user/profile/update" method="POST" id="updateProfileForm"> 
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password:</label>
                                    <input type="password" id="current_password" name="current_password" class="form-control">
                                    @error('current_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password:</label>
                                    <input type="password" id="new_password" name="new_password" class="form-control">
                                    @error('new_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Confirm New Password:</label>
                                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control">
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" form="updateProfileForm">Update Profile</button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <h1>Welcome, Guest</h1>
            <a href="/user/login">Login</a>
            <a href="/user/register">Register</a>
        @endif
    </div>

@endsection
