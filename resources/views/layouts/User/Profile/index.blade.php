@extends('main')
@section('content')
    <div class="pt-1 row">
        <div class="col-12 col-md-12 col-lg-5">
            <div class="card profile-widget">
                <div class="profile-widget-header">
                    <img alt="image"
                        src="{{ $user->profile_picture != null ? asset($user->profile_picture) : asset('img/avatar/avatar-1.png') }}"
                        class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items">
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Posts</div>
                            <div class="profile-widget-item-value">187</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Followers</div>
                            <div class="profile-widget-item-value">6,8K</div>
                        </div>
                        <div class="profile-widget-item">
                            <div class="profile-widget-item-label">Following</div>
                            <div class="profile-widget-item-value">2,1K</div>
                        </div>
                    </div>
                </div>
                <div class="profile-widget-description">
                    <div class="profile-widget-name">{{ $user->username }}<div
                            class="text-muted d-inline font-weight-normal">
                            <div class="slash"></div> {{ $user->role == 'M' ? 'Mentor' : 'Student' }}
                        </div>
                    </div>
                    Ujang maman is a superhero name in <b>Indonesia</b>, especially in my family. He is not a fictional
                    character but an original hero in my family, a hero for his children and for his wife. So, I use the
                    name as
                    a user in this template. Not a tribute, I'm just bored with <b>'John Doe'</b>.
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-7">
            <div class="card">
                <form id="profile-update" method="post" class="needs-validation" novalidate="">
                    <div class="card-header">
                        <h4>Edit Profile
                            {{ $user->first_name == null ? $user->username : $user->first_name . $user->last_name }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-12 col-md-6">
                                <label>Student Indentification Number</label>
                                <input type="text" name="student_identification_number" class="form-control"
                                    value="{{ $user->student_identification_number }}" disabled>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" value="{{ $user->username }}">
                                <div class="invalid-feedback">
                                    Please fill in the first name
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control"
                                    value="{{ $user->first_name }}">
                                <div class="invalid-feedback">
                                    Please fill in the first name
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}">
                                <div class="invalid-feedback">
                                    Please fill in the last name
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label>Address</label>
                                <textarea type="text" name="address" class="form-control" value="{{ $user->address }}"></textarea>
                                <div class="invalid-feedback">
                                    Please fill in the last name
                                </div>
                            </div>
                            <div class="form-group col-md-7 col-12">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                                <div class="invalid-feedback">
                                    Please fill in the email
                                </div>
                            </div>
                            <div class="form-group col-md-5 col-12">
                                <label>Phone</label>
                                <input type="tel" name="phone_number" class="form-control"
                                    value="{{ $user->phone_number }}">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Gender</label>
                                <select class="form-control" name="gender" id="gender">
                                    <option value="">Not filled in yet</option>
                                    <option {{ $user->gender == 'W' ? 'selected' : '' }} value="W">Women</option>
                                    <option {{ $user->gender == 'M' ? 'selected' : '' }} value="M">Men</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer row justify-content-end">
                        <button type="button" class="btn btn-danger text-white m-1 col-12 col-sm-5"><i
                                class="fas fa-lock"></i> Change
                            Password</button>
                        <button id="update-profile" type="button" class="btn btn-warning m-1 col-12 col-sm-5"><i
                                class="fas fa-pen"></i> Update
                            Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $("#update-profile").click(function() {
                let data = $("#profile-update").serializeArray();
            });
        });
    </script>
@endsection
