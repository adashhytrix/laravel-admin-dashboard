@extends('layouts.adminApp')
@section('title', 'User Create')
@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Create User & Assign Role</h4>

        <a href="{{ route('admin.users.index') }}"
           class="btn btn-outline-secondary">
            Back to Users
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Enter full name"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Address</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="user@example.com"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            required
                        >
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3">Assign Role</h5>

                @error('roles')
                    <div class="text-danger small mb-2">{{ $message }}</div>
                @enderror

                <div class="row">
                    @forelse($roles as $role)
                        <div class="col-md-4 mb-3">
                            <label class="form-check border rounded p-3 ps-5">
                                <input
                                    type="checkbox"
                                    name="roles[]"
                                    value="{{ $role->id }}"
                                    class="form-check-input"
                                    @checked(in_array(
                                        $role->id,
                                        old('roles', [])
                                    ))
                                >

                                <span class="form-check-label">
                                    <strong>{{ $role->name }}</strong>
                                    <small class="d-block text-muted">
                                        {{ $role->slug }}
                                    </small>
                                </span>
                            </label>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning">
                                No roles found. Please create a role first.
                            </div>
                        </div>
                    @endforelse
                </div>

                @error('roles.*')
                    <div class="text-danger small mb-2">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn btn-primary"
                    @disabled($roles->isEmpty())>
                    Create User
                </button>

                <a href="{{ route('admin.users.index') }}"
                   class="btn btn-light border">
                    Cancel
                </a>
            </form>

        </div>
    </div>
</div>
@endsection