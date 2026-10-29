
@extends('layouts.adminApp')
@section('title', 'Permission Edit')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Permission</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.permissions.update', $permission) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">
                        Permission Name
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $permission->name) }}"
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">
                        Permission Slug
                    </label>
                    <input type="text"
                           id="slug"
                           name="slug"
                           class="form-control @error('slug') is-invalid @enderror"
                           value="{{ old('slug', $permission->slug) }}"
                           required>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Update Permission
                </button>

                <a href="{{ route('admin.permissions.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
