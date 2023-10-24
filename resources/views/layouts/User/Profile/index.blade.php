@extends('main')
@section('content')
    <div class="pt-1 row">
        @if (session('try_again'))
            <div class="col-12">
                <div class="alert alert-warning">
                    {{ session('try_again') }}
                </div>
            </div>
        @endif
        @if (session('email'))
            <div class="col-12">
                <div class="alert alert-info">
                    {{ session('email') }}
                </div>
            </div>
        @endif
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
                            {{ $user->first_name == null ? $user->username : $user->first_name . $user->last_name }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control"
                                    value="{{ $user->first_name }}">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label>Address</label>
                                <textarea type="text" name="address" class="form-control">{{ $user->address }}</textarea>
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="form-group col-md-7 col-12">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                            <div class="form-group col-md-5 col-12">
                                <label>Phone Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                    </div>
                                    <input type="text" name="phone_number" class="form-control phone-number"
                                        value="{{ $user->phone_number }}">
                                    <div class="invalid-feedback">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Gender</label>
                                <select class="form-control" name="gender" id="gender">
                                    <option value="">Not filled in yet</option>
                                    <option {{ $user->gender == 'W' ? 'selected' : '' }} value="W">Women</option>
                                    <option {{ $user->gender == 'M' ? 'selected' : '' }} value="M">Men</option>
                                </select>
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer row justify-content-end">
                        <button id="change-password" type="button"
                            class="btn btn-danger text-white m-1 col-12 col-sm-5 {{ date('Y-m-d', time() + 7 * 60 * 60) == $user->last_reset_password ? 'disabled' : '' }}"><i
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
    <script src="{{ asset('modules/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#update-profile").click(function() {
                let post_data = serializeObject($("#profile-update"));
                $('.is-invalid').removeClass('is-invalid')
                $.ajax({
                    type: "PUT",
                    url: `{{ route('user.profile.update') }}`,
                    data: post_data,
                    dataType: "json",
                    success: function(response) {
                        swal(response.message, {
                            icon: 'success'
                        });
                        setTimeout(() => {
                            swal.close();
                            location.reload()
                        }, 1500);
                    },
                    error: function(error) {
                        let errors = error.responseJSON.errors
                        if (errors != undefined) {
                            $.each(errors, function(index, error_list) {
                                let html = ``;
                                error_list.forEach(element => {
                                    html +=
                                        `<li class="list-group-item border-0">${element}</li>`;
                                });
                                $(`[name=${index}]`).addClass('is-invalid').siblings(
                                    '.invalid-feedback').html(html);
                            });
                        }
                    }
                });
            });
            $("#change-password").click(function() {
                swal({
                        title: 'Are you sure?',
                        text: 'Once change password, the password will be change permanently!',
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willChange) => {
                        if (willChange) {
                            swal('We are processing your request', {
                                icon: 'success',
                            });
                            $.ajax({
                                type: "post",
                                url: `{{ route('user.profile.last-change-password', session('auth.id')) }}`,
                                data: {
                                    '_token': `{{ csrf_token() }}`
                                },
                                dataType: "json",
                                success: function(response) {
                                    setTimeout(() => {
                                        swal.close()
                                        window.location.href =
                                            `{{ route('user.profile.change-password') }}`;
                                    }, 1500);
                                },
                                error: function(error) {
                                    swal(error.responseJSON.message + ' 🤣', {
                                        icon: 'success'
                                    });
                                    $("#change-password").addClass('disabled');
                                }
                            });
                        } else {
                            swal('Canceling your process', {
                                icon: 'info'
                            });
                        }
                    });
            })
        });
    </script>
@endsection
