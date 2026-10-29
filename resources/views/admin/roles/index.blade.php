@extends('layouts.adminApp')
@section('title', 'Role List')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Roles & Permissions</h4>

        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            + Create Role
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Role Name</th>
                        <th>Slug</th>
                        <th>Permissions</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{ $roles->firstItem() + $loop->index }}</td>
                            <td class="fw-semibold">{{ $role->name }}</td>
                            <td>
                                <span class="badge bg-light text-dark">
                                    {{ $role->slug }}
                                </span>
                            </td>
                            <td>
                                @forelse($role->permissions as $permission)
                                    <span class="badge bg-info text-dark mb-1">
                                        {{ $permission->slug }}
                                    </span>
                                @empty
                                    <span class="text-muted">No permissions</span>
                                @endforelse
                            </td>
                            <td>
                                <a href="{{ route('admin.roles.edit', $role) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                No roles found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white">
            {{ $roles->links() }}
        </div>
    </div>
</div>
@endsection