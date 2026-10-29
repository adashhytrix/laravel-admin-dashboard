@extends('layouts.adminApp')
@section('title', 'Role Create')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Create Role</h4>

        <a href="{{ route('admin.roles.index') }}"
           class="btn btn-outline-secondary">
            Back to Roles
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Role Name</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="e.g. Manager"
                        required
                    >

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Role Slug (optional)</label>
                    <input
                        type="text"
                        name="slug"
                        class="form-control @error('slug') is-invalid @enderror"
                        value="{{ old('slug') }}"
                        placeholder="e.g. manager"
                    >

                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="form-text">
                        Leave blank to generate the slug from the role name.
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Assign Permissions</h5>

                    <button type="button"
                            class="btn btn-sm btn-outline-primary"
                            id="selectAllPermissions">
                        Select All
                    </button>
                </div>

                @error('permissions')
                    <div class="text-danger small mb-2">{{ $message }}</div>
                @enderror

                <div class="row">
                    @forelse($permissions as $permission)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="form-check border rounded p-3 ps-5">
                                <input
                                    class="form-check-input permission-checkbox"
                                    type="checkbox"
                                    name="permissions[]"
                                    value="{{ $permission->id }}"
                                    id="permission{{ $permission->id }}"
                                    @checked(in_array(
                                        $permission->id,
                                        old('permissions', [])
                                    ))
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
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning">
                                No permissions found. Create permissions first.
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        Save Role
                    </button>

                    <a href="{{ route('admin.roles.index') }}"
                       class="btn btn-light border">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('selectAllPermissions')?.addEventListener('click', function () {
    const checkboxes = document.querySelectorAll('.permission-checkbox');
    const allChecked = [...checkboxes].every(checkbox => checkbox.checked);

    checkboxes.forEach(checkbox => {
        checkbox.checked = !allChecked;
    });

    this.textContent = allChecked ? 'Select All' : 'Deselect All';
});
</script>
@endsection