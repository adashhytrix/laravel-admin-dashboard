@extends('layouts.adminApp')
@section('title', 'User Edit')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Edit User & Assign Roles</h4>
            <p class="text-muted mb-0">Update user details and role access.</p>
        </div>

        <a href="{{ route('admin.users.index') }}"
           class="btn btn-outline-secondary">
            Back to Users
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <form action="{{ route('admin.users.update', $user) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <h5 class="mb-3">User Details</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}"
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
                            value="{{ old('email', $user->email) }}"
                            required
                        >

                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">New Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Leave blank to keep current password"
                        >

                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Confirm New Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Confirm new password"
                        >
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="mb-1">Assign Roles</h5>
                        <small class="text-muted">
                            Selected roles will be assigned to this user.
                        </small>
                    </div>

                    <button type="button"
                            class="btn btn-sm btn-outline-primary"
                            id="toggleRoles">
                        Select All
                    </button>
                </div>

                @error('roles')
                    <div class="text-danger small mb-2">{{ $message }}</div>
                @enderror

                @error('roles.*')
                    <div class="text-danger small mb-2">{{ $message }}</div>
                @enderror

                <div class="row">
                    @forelse($roles as $role)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <label class="form-check border rounded p-3 ps-5 h-100">
                                <input
                                    type="checkbox"
                                    name="roles[]"
                                    value="{{ $role->id }}"
                                    class="form-check-input role-checkbox"
                                    @checked(in_array(
                                        $role->id,
                                        old('roles', $assignedRoles)
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

                <div class="mt-4">
                    <button type="submit"
                            class="btn btn-primary"
                            @disabled($roles->isEmpty())>
                        Update User & Roles
                    </button>

                    <a href="{{ route('admin.users.index') }}"
                       class="btn btn-light border">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('toggleRoles')?.addEventListener('click', function () {
    const checkboxes = [...document.querySelectorAll('.role-checkbox')];
    const allChecked = checkboxes.length > 0 &&
        checkboxes.every(checkbox => checkbox.checked);

    checkboxes.forEach(checkbox => {
        checkbox.checked = !allChecked;
    });

    this.textContent = allChecked ? 'Select All' : 'Deselect All';
});
</script>
@endsection
