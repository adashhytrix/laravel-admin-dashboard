  <style>

    /* Sidebar mini hone par user section hide */
.sidebar-mini .sidebar-user {
    display: none !important;
}

  </style>
  <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <a class="brand-mark" href="{{route('admin.dashboard')}}" aria-label="adminHMD dashboard">
          <span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span>
          <span class="brand-copy">
            <span class="brand-title">Admin</span>
            <span class="brand-subtitle">Admin Template</span>
          </span>
        </a>
      </div>

      <nav class="sidebar-nav">
         @if (auth('admin')->user()?->hasPermission('dashboard.view'))
        <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" aria-current="page">
          <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
          <span class="nav-text">Dashboard</span>
        </a>
        @endif
        @if (auth('admin')->user()?->hasPermission('users.view'))
        <a class="nav-link {{ Request::is('admin/user/user-list') ? 'active' : '' }}" href="{{ route('admin.user.index') }}">
          <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
          <span class="nav-text">Users</span>
        </a>
        @endif
{{-- @if (auth('admin')->user()?->hasPermission('users.create'))
        <a class="nav-link {{ Request::is('admin/user/create') ? 'active' : '' }}" href="{{ route('admin.user.create') }}">
          <span class="nav-icon"><i class="bi bi-person-plus" aria-hidden="true"></i></span>
          <span class="nav-text">Add User</span>
        </a>
        @endif --}}
@if (auth('admin')->user()?->hasPermission('profile.view'))
        <a class="nav-link {{ Request::is('admin/user/profile') ? 'active' : '' }}" href="{{ route('admin.profile.index') }}">
          <span class="nav-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
          <span class="nav-text">Profile</span>
        </a>
        @endif
@if (auth('admin')->user()?->hasPermission('chart.view'))
        <a class="nav-link {{ Request::is('admin/charts') ? 'active' : '' }} " href="{{ route('admin.charts') }}">
          <span class="nav-icon"><i class="bi bi-bar-chart-line" aria-hidden="true"></i></span>
          <span class="nav-text">Charts</span>
        </a>
        @endif
@if (auth('admin')->user()?->hasPermission('roles.view'))
        <a class="nav-link  {{ Request::is('admin/roles') ? 'active' : '' }} " href="{{ route('admin.roles.index') }}">
          <span class="nav-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
          <span class="nav-text">Role</span>
        </a>
        @endif
        @if (auth('admin')->user()?->hasPermission('permissions.view'))
        <a class="nav-link {{ Request::is('admin/permissions') ? 'active' : '' }}" href="{{ route('admin.permissions.index') }}">
          <span class="nav-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
          <span class="nav-text">Permissions</span>
        </a>
        @endif
        {{-- 
        <a class="nav-link" href="{{ route('admin.forms') }}">
          <span class="nav-icon"><i class="bi bi-ui-checks-grid" aria-hidden="true"></i></span>
          <span class="nav-text">Forms</span>
        </a>
        <a class="nav-link" href="{{ route('admin.components') }}">
          <span class="nav-icon"><i class="bi bi-grid-3x3-gap" aria-hidden="true"></i></span>
          <span class="nav-text">Components</span>
        </a> --}}
        @if (auth('admin')->user()?->hasPermission('alerts.view'))
        <a class="nav-link" href="alerts.html">
          <span class="nav-icon"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i></span>
          <span class="nav-text">Alerts</span>
        </a>
        @endif
         @if (auth('admin')->user()?->hasPermission('models.view'))
        <a class="nav-link" href="modals.html">
          <span class="nav-icon"><i class="bi bi-window-stack" aria-hidden="true"></i></span>
          <span class="nav-text">Modals</span>
        </a>
        @endif

         @if (auth('admin')->user()?->hasPermission('settings.view'))
        <a class="nav-link" href="settings.html">
          <span class="nav-icon"><i class="bi bi-gear" aria-hidden="true"></i></span>
          <span class="nav-text">Settings</span>
        </a>
        @endif
         @if (auth('admin')->user()?->hasPermission('Blank.page'))
        <a class="nav-link" href="blank.html">
          <span class="nav-icon"><i class="bi bi-file-earmark" aria-hidden="true"></i></span>
          <span class="nav-text">Blank Page</span>
        </a>
        @endif
      </nav>

      <div class="sidebar-user ">
             @if(auth('admin')->user()?->profile_image)
    <img
        class="avatar-img avatar-md sidebar-user-avatar"
        src="{{ Storage::url(auth('admin')->user()?->profile_image) }}"
        alt="{{ auth('admin')->user()?->name }}"
    >
@else
<img class="avatar-img avatar-md sidebar-user-avatar" src="{{asset('assets/images/avatar/avatar.jpg')}}" alt="{{auth('admin')->user()?->name}}"> 
    
@endif
      
        <strong>{{auth('admin')->user()?->name}}</strong>
        <small>Active Workspace</small>
      </div>

      <div class="sidebar-footer">
        <span class="status-dot"></span>
        <span class="sidebar-footer-text">System running smoothly</span>
      </div>
    </aside>