
@extends('layouts.adminApp')
@section('title', 'Permission List')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Permissions</h4>
        <a href="{{ route('admin.permissions.create') }}"
           class="btn btn-primary">
            + Add Permission
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            Please check your submitted data.
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        {{-- <th width="180">Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $permission)
                        <tr>
                            <td>{{ $permissions->firstItem() + $loop->index }}</td>
                            <td>{{ $permission->name }}</td>
                            <td><code>{{ $permission->slug }}</code></td>
                            {{-- <td>
                                <a href="{{ route('admin.permissions.edit', $permission) }}"
                                   class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <form action="{{ route('admin.permissions.destroy', $permission) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this permission?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td> --}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                No permissions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-4">
    <div class="text-muted small">
        Showing {{ $permissions->firstItem() ?? 0 }}
        to {{ $permissions->lastItem() ?? 0 }}
        of {{ $permissions->total() }} permissions
    </div>

    <div>
        {{ $permissions->onEachSide(1)->links() }}
    </div>
</div>
            {{-- {{ $permissions->links() }} --}}
        </div>
    </div>
</div>
@endsection
