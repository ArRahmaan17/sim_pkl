@extends('main')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Form Attendance</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('user.attendance.process') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <input type="hidden" name="location">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control" readonly
                        value="{{ $user->first_name . ' ' . $user->last_name }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div class="selectgroup w-100">
                        @if ($history == 0)
                            <label class="selectgroup-item">
                                <input type="radio" name="status" value="IN" class="selectgroup-input" checked>
                                <span class="selectgroup-button"><i class="fas fa-sign-in-alt"></i> IN</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="status" value="SICK" class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-hospital-alt"></i> SICK</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="status" value="ABSENT" class="selectgroup-input">
                                <span class="selectgroup-button"><i class="fas fa-question"></i> ABSENT</span>
                            </label>
                        @else
                            <label class="selectgroup-item">
                                <input type="radio" name="status" value="OUT" class="selectgroup-input" checked>
                                <span class="selectgroup-button"><i class="fas fa-sign-out-alt"></i> OUT</span>
                            </label>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label>Please take a picture:</label>
                    <div id="camera" class="p-2 mx-auto mx-sm-0 my-3"></div>
                    <button type="button" id="btn-shot" class="btn btn-danger mx-auto mx-sm-2" onclick="take_picture()">
                        <i class="fas fa-camera"></i>
                    </button>
                    <button id="btn-reset" onclick="get_ready()" type="button" class="btn btn-warning d-none"><i
                            class="fas fa-sync"></i></button>
                </div>
                <div class="form-group">
                    <label>Result</label>
                    <div id="results" class="col-12 col-sm-8 col-md-6"></div>
                    <input id="result-data" name="photo" type="hidden">
                </div>
                <button class="btn btn-success" disabled type="submit"><i class="fas fa-fingerprint"></i> Loading
                    Get Location</button>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script>
        let width;
        let height;
        $(function() {
            $('button[type=submit]').attr('disabled');
            navigator.geolocation.getCurrentPosition(function(location) {
                $("input[name=location]").val(location.coords.latitude + ',' + location.coords.longitude)
                    .trigger('change');
            });
            $("input[name=location]").change(function() {
                $('button[type=submit]').removeAttr('disabled');
                $('button[type=submit]').html('<i class="fas fa-fingerprint"></i> Absent');
            })
            get_ready();
        });

        async function get_ready() {
            let stream = await navigator.mediaDevices.getUserMedia({
                video: true
            })
            width = stream.getVideoTracks()[0].getSettings().width;
            height = stream.getVideoTracks()[0].getSettings().height;
            if ($(window).innerWidth() < 768) {
                width = width / 2;
                height = height / 2;
            } else if ($(window).innerWidth() < 1200) {
                width = width / (1.5);
                height = height / (1.5);
            } else {
                width = width / (.9);
                height = height / (.9);
            }
            Webcam.set({
                width: width,
                height: height,
                dest_width: width,
                dest_height: height,
                image_format: 'jpeg',
                jpeg_quality: 100
            });

            Webcam.attach('#camera');
            $('#camera').removeClass('d-none');
            $('#btn-shot').removeClass('d-none');
            $('#btn-reset').addClass('d-none');
        }

        function take_picture() {
            Webcam.snap(function(picture_data) {
                document.getElementById('results').innerHTML =
                    `<img src="${picture_data}"/>`;
                Webcam.reset();
                $('#camera').addClass('d-none');
                $('#btn-shot').addClass('d-none');
                $('#btn-reset').removeClass('d-none');
                var raw_image_data = picture_data.replace(/^data\:image\/\w+\;base64\,/, '');
                $("#result-data").val(raw_image_data)
            });
        }
    </script>
@endsection
