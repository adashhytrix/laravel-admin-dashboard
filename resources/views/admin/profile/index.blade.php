@extends('layouts.adminApp')
@section('content')
    
      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
          <div class="page-heading">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">Account</p>
                <h1 class="h3 mb-1">Profile</h1>
                <p class="text-muted mb-0">Manage your personal details, bio, and contact preferences.</p>
              </div>
            </div>
            
          </div>

          <section class="row g-3">
            <div class="col-12 col-xl-4">
              <div class="panel h-100 text-center profile-card">
                <div class="profile-cover"><img src="{{asset('assets/images/png/dasher-ui-bootstrap-5.jpg')}}" alt="adminHMD dashboard preview"></div>
               @if($admin->profile_image)
    <img
        class="avatar-img avatar-xl profile-photo"
        src="{{ Storage::url($admin->profile_image) }}"
        alt="{{ $admin->name }}"
    >
@else
    <img
        class="avatar-img avatar-xl profile-photo"
        src="{{ asset('assets/images/avatar/avatar.jpg') }}"
        alt="{{ $admin->name }}"
    >
@endif
                <h2 class="h5 mt-3 mb-1">{{ $admin->name }}</h2>
                @foreach($admin->roles as $role)
                  <p class="text-muted mb-3"> {{ $role->name }} </p>
               
                @endforeach
              
                <div class="d-flex justify-content-center gap-2">
                  <span class="badge text-bg-primary">Admin</span>
                  <span class="badge text-bg-success">Verified</span>
                </div>
                <div class="info-list mt-4 text-start">
                  <div>
                    <span>Email</span><strong>{{ $admin->email }}</strong>
                    
                  </div>
              
                  </div>
                    <div>
                   
                     <span>Bio </span>
                     <br> <hr><strong>{{ $admin->bio }}</strong>
                  </div>
                  
              </div>
            </div>
            <div class="col-12 col-xl-8">
              <form action="{{ route('admin.user.update') }}"  method="POST" class="panel needs-validation" enctype="multipart/form-data" >
                @csrf
                @method('PUT')
                <div class="panel-header"><div><h2 class="h5 mb-1 section-title"><i class="bi bi-person-gear" aria-hidden="true"></i><span>Profile Settings</span></h2><p class="text-muted mb-0">Update your account profile and contact details.</p></div></div>
                <div class="row g-3">
                    <div class="col-md-6">

                      
                
                       <label class="form-label" for="profileName">Profile image</label>
                        <input class="form-control" type="file" name="profile_image" id="profile_image" value="{{ $admin->profile_image }}" >
                        <div class="invalid-feedback">Name is required.</div>

                        <label class="form-label" for="profileName">Name</label>
                        <input class="form-control" name="name" id="profileName" type="text" value="{{ $admin->name }}" required>
                        <div class="invalid-feedback">Name is required.</div></div>
                    


                        <div class="col-12">
                            <label class="form-label" for="profileBio">Bio</label>
                            <textarea name="bio" class="form-control" id="profileBio" rows="5">{{ $admin->bio }}</textarea>
                        </div>
                    </div>
                      <div class="d-flex justify-content-between align-items-center mt-4">
                      
          

                       
                    <button class="btn btn-primary" type="submit"><i class="bi bi-check2-circle" aria-hidden="true"></i> Save Profile</button>
              
                {{-- Validation Error --}}
            @error('name')
                <p class="text-danger">{{ $message }}</p>
            @enderror
   @error('bio')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            {{-- Success Message --}}
            @if (session('success'))
                <p class="text-success">{{ session('success') }}</p>
            @endif
                  </div>

              </form>
            </div>
          </section>
        </div>
      </main>
@endsection