@extends('layouts.adminApp')
@section('title', 'Role Edit')

@section('content')
<div class="container-fluid py-4">
    <h4 class="mb-4">Edit Role: {{ $role->name }}</h4>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Role Name</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $role->name) }}"
                        required
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Role Slug</label>
                    <input
                        type="text"
                        name="slug"
                        class="form-control @error('slug') is-invalid @enderror"
                        value="{{ old('slug', $role->slug) }}"
                        required
                    >
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <h5 class="mb-3">Assign Permissions</h5>

                @php
                    $selected = old('permissions', $assignedPermissions);
                @endphp

                <div class="row">
                    @foreach($permissions as $permission)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-check border rounded p-3 ps-5">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="permissions[]"
                                    value="{{ $permission->id }}"
                                    id="permission{{ $permission->id }}"
                                    @checked(in_array($permission->id, $selected))
                                >

                                <label class="form-check-label"
                                       for="permission{{ $permission->id }}">
                                    <strong>{{ $permission->name }}</strong>
                                    <small class="d-block text-muted">
                                        {{ $permission->slug }}
                                    </small>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button class="btn btn-primary" type="submit">
                    Update Role
                </button>

                <a href="{{ route('admin.roles.index') }}"
                   class="btn btn-light border">
                    Cancel
                </a>
            </form>
        </div>
    </div>
</div>
@endsection