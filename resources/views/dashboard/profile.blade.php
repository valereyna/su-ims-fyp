
@extends('layouts.master')
@section('content')

<style>
    .profile-header {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 30px;
    }
    .profile-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid #007bff;
        cursor: pointer;
        flex-shrink: 0;
    }
    .profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Ensures image covers the container without distortion */
        border-radius: 50%;
        transition: transform 0.3s ease;
    }
    .profile-image img:hover {
        transform: scale(1.05);
        box-shadow: 0 0 10px #007bff;
    }
    .profile-user-info h4 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
        color: #343a40;
    }
    .profile-user-info h6 {
        font-size: 18px;
        color: #6c757d;
        font-weight: 500;
    }
    .profile-btn ms-auto a.btn-primary {
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }
    .profile-btn ms-auto a.btn-primary:hover {
        background-color: #0056b3;
    }
</style>

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ul>
                </div>
            </div>
        </div>

        
        <div class="profile-header">
            <div class="profile-image">
                <form action="{{ route('profile.update_avatar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="avatar-upload" title="Change Profile Picture" style="cursor:pointer; display:block; width:100%; height:100%;">
                        <img alt="{{ Session::get('name') }}" src="/images/{{ Session::get('avatar') }}">
                    </label>
                    <input type="file" id="avatar-upload" name="avatar" style="display:none;" onchange="this.form.submit()">
                </form>
            </div>
            <div class="profile-user-info">
                <h4>{{ Session::get('name') }}</h4>
                <h6>{{ Session::get('position') }}</h6>
            </div>
        </div>

        <div class="profile-menu">
            <ul class="nav nav-tabs nav-tabs-solid">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#per_details_tab">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#password_tab">Password</a>
                </li>
            </ul>
        </div>

        <div class="tab-content profile-tab-cont">
            <div class="tab-pane fade show active" id="per_details_tab">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title d-flex justify-content-between">
                                    <span>Personal Details</span>
                                    <a class="edit-link" data-bs-toggle="modal" href="#edit_personal_details"><i class="far fa-edit me-1"></i>Edit</a>
                                </h5>
                                <div class="row">
                                    <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Name</p>
                                    <p class="col-sm-9">{{ Session::get('name') }}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Date of Birth</p>
                                    <p class="col-sm-9 ">{{ Session::get('date_of_birth') }}</p> 
                                </div>
                                <div class="row">
                                    <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Email</p>
                                    <p class="col-sm-9"><a href="/cdn-cgi/l/email-protection"
                                            class="__cf_email__"
                                            data-cfemail="a1cbcec9cfc5cec4e1c4d9c0ccd1cdc48fc2cecc">{{ Session::get('email') }}</a>
                                    </p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Mobile</p>
                                    <p class="col-sm-9">{{ Session::get('phone_number') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title d-flex justify-content-between">
                                    <span>Account Status</span>
                                    <a class="edit-link" href="#"><i class=""></i></a>
                                </h5>
                                <button class="btn btn-success" type="button"><i class="fe fe-check-verified"></i> {{ Session::get('status') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="password_tab" class="tab-pane fade">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Change Password</h5>
                        <div class="row">
                            <div class="col-md-10 col-lg-6">
                                <form action="{{ route('change.password') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Old Password</label>
                                        <input type="password" class="form-control " name="current_password" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" class="form-control" name="new_password" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Confirm New Password</label>
                                        <input type="password" class="form-control" name="new_password_confirmation" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="edit_personal_details" tabindex="-1" aria-labelledby="editPersonalDetailsLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPersonalDetailsLabel">Edit Personal Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Session::get('name')) }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="date_of_birth">Date of Birth</label>
                                <input type="date" class="form-control datetimepicker" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', Session::get('date_of_birth')) }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Session::get('email')) }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="phone_number">Mobile</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', Session::get('phone_number')) }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
