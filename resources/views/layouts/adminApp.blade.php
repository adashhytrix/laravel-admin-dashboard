<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="adminHMD professional admin dashboard template">
  {{-- <title>Dashboard </title> --}}
  <title>@yield('title', 'Admin Panel')</title>

  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
  
   <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    @include('partials.aside')


    <div class="admin-main">
        @include('partials.nav')

        @yield('content')
       
       @include('partials.footer')
      
    </div>
  </div>

 
  @stack('scripts')
  @php
    $admin = auth('admin')->user();
@endphp

<script>
    window.adminHMDUser = @json([
        'name' => $admin?->name ?? 'Admin',
        'workspace' => 'Active Workspace',
        'avatar' => $admin?->profile_image
            ? asset('storage/' . $admin->profile_image)
            : asset('assets/images/avatar/avatar.jpg')
    ]);
</script>
  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>