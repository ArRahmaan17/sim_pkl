@extends('main')
@section('css')
    <link rel="stylesheet" href="{{ asset('modules/dropzonejs/min/basic.min.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <article class="article">
                <div class="article-header">
                    <div class="article-image"
                        style='background-image: url("data:image/png;base64,{{ tasks_asset('' . $task->thumbnail) }}"); background-size:cover; background-position: center center;'>
                    </div>
                    <div class="article-title">
                        <h2><a>{{ $task->title }}</a></h2>
                        <p class="text-small text-white">{{ $task->created_at }}</p>
                    </div>
                </div>
                <div class="article-details">
                    <p>{!! $task->content !!}</p>
                    <div class="article-cta">
                        @if ($task->status == 'Pending')
                            <button type="button" class="btn btn-warning disabled time-count"><i
                                    class="fas fa-hourglass-end fa-spin"></i> The processing time in
                                {{ now()->parse($task->start_date . ' 00:01:01', 'Asia/Jakarta')->longRelativeDiffForHumans(now('Asia/Jakarta')->format('Y-m-d H:i:s')) }}</button>
                        @elseif ($task->status == 'Progress')
                            @if ($countStartTask == 0)
                                <button type="button" onclick="startTask()" class="btn btn-success time-count"><i
                                        class="fas fa-play"></i>
                                    Start before
                                    {{ now()->parse($task->deadline_date . ' 23:59:59', 'Asia/Jakarta')->longRelativeDiffForHumans(now('Asia/Jakarta')->format('Y-m-d H:i:s')) }}</button>
                            @else
                                <button type="button" onclick="showFormStoreTask()" class="btn btn-success time-count"
                                    {{ $countTask == 0 ? '' : 'disabled' }}><i class="fas fa-upload"></i>
                                    Upload before
                                    {{ now()->parse($task->deadline_date . ' 23:59:59', 'Asia/Jakarta')->longRelativeDiffForHumans(now('Asia/Jakarta')->format('Y-m-d H:i:s')) }}</button>
                            @endif
                        @elseif ($task->status == 'End')
                            <button type="button" class="btn btn-danger disabled time-count"><i
                                    class="far fa-calendar-times"></i> The processing
                                time is up in
                                {{ now()->parse($task->deadline_date . ' 23:59:59', 'Asia/Jakarta')->longRelativeDiffForHumans(now('Asia/Jakarta')->format('Y-m-d H:i:s')) }}</button>
                        @endif
                        <button class="btn btn-info" onclick="showAllFilesUploaded()"><i class="fas fa-file"></i>
                            {{ session('auth.role') == 'M' ? 'All file' : 'Your Activity' }}</button>
                    </div>
                </div>
            </article>
        </div>
    </div>
@endsection
@section('modals')
    <div class="modal fade" id="modal-store-task" tabindex="-1" role="dialog" data-keyboard='false' data-backdrop="static"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Store Your Task</h5>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger count-time-form">
                        <i class="fas fa-clock"></i>
                    </div>
                    <form id="form-store-task">
                        <div class="alert alert-danger create d-none">
                            <div class="alert-title">We Found Some Error</div>
                            <div class="alert-body">
                            </div>
                        </div>
                        @csrf
                        <input type="hidden" name="user_id" value="{{ session('auth.id') }}">
                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                        <div class="form-group">
                            <label>Name</label>
                            <input name='name' type="text" class="form-control" readonly
                                value="{{ session('auth.first_name') . ' ' . session('auth.last_name') }}">
                        </div>
                        <div class="form-group">
                            <label>Link</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">https://github.com/</span>
                                </div>
                                <input type="text" class="form-control" name="link"
                                    placeholder="github-username/repository-name">
                                <div class="input-group-append">
                                    <span class="input-group-text">.git</span>
                                </div>
                            </div>
                            <small id="passwordHelpBlock" class="form-text text-warning">
                                *please make sure your github repository is public
                            </small>
                        </div>
                        <div class="col-12">
                            <div id="dropzone" class="dropzone"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>
                        Close</button>
                    <button id="save-file-task" type="button" class="btn btn-primary"><i class="fas fa-save"></i> Store
                        Task</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-activity-task" tabindex="-1" role="dialog" data-keyboard='false'
        data-backdrop="static" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Update Your Task Progress</h5>
                </div>
                <div class="modal-body">
                    <form id="form-update-activity">
                        <div class="alert alert-danger create d-none">
                            <div class="alert-title">We Found Some Error</div>
                            <div class="alert-body">
                            </div>
                        </div>
                        @csrf
                        <input type="hidden" name="user_id" value="{{ session('auth.id') }}">
                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                        <input type="hidden" name="extension" value="">
                        <input type="hidden" name="progress" value="">
                        <input type="hidden" name="start" value="">
                        <div class="form-group">
                            <label>Name</label>
                            <input name='name' type="text" class="form-control" readonly
                                value="{{ session('auth.first_name') . ' ' . session('auth.last_name') }}">
                        </div>
                        <div class="form-group">
                            <label>Status activity</label>
                            <input name='status' type="text" class="form-control" readonly value="">
                        </div>
                        <div class="form-group">
                            <label>Describe your activity</label>
                            <textarea class="form-control" name="description" cols="30" rows="10"></textarea>
                        </div>
                        <div class="col-12">
                            <label for="">Screenshot evidence</label>
                            <div id="activity-dropzone" class="dropzone"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>
                        Close</button>
                    <button id="update-activity-task" type="button" class="btn btn-primary"><i class="fas fa-pen"></i>
                        Update activity Task</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-all-task-file" tabindex="-1" role="dialog" data-keyboard='false'
        data-backdrop="static" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        {{ session('auth.role') == 'M' ? 'All file uploaded' : 'Your activity' }}
                        on task {{ $task->title }}</h5>
                </div>
                <div class="modal-body" style="height: 600px; overflow:scroll;">
                    @if (session('auth.role') == 'M')
                        @forelse ($task->allFile as $file)
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{ $file->taskUser->username }}'s file</h4>
                                    <div class="card-header-action">
                                        <a data-collapse="#mycard-collapse-{{ $file->id }}"
                                            class="btn btn-icon btn-info" href="#"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                                <div class="collapse" id="mycard-collapse-{{ $file->id }}">
                                    <div class="card-body">
                                        <p class="task-collection">
                                            Task collection on
                                            {{ now()->parse(explode('.000', $file->created_at)[0], 'Asia/Jakarta')->longRelativeDiffForHumans(now('Asia/Jakarta')->format('Y-m-d H:i:s')) }}
                                        </p>
                                    </div>
                                    <div class="card-footer bg-whitesmoke">
                                        @if ($file->link != null)
                                            <a href="https://github.com/{{ $file->like }}.git" target="_blank">Github
                                                page</a>
                                        @else
                                            <a href="{{ route('user.todo.download', $file->id) }}"
                                                target="_blank">Download
                                                File</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            Empty File
                        @endforelse
                    @else
                        <div class="activities">
                            @forelse ($activity_task as $activity)
                                <div class="activity">
                                    <div class="activity-icon bg-primary text-white shadow-primary">
                                        @if ($activity->status == 'Shared')
                                            <i class="fas fa-share"></i>
                                        @elseif ($activity->status == 'Started')
                                            <i class="fas fa-play"></i>
                                        @elseif ($activity->status == 'Analysis')
                                            <i class="fas fa-search"></i>
                                        @elseif ($activity->status == 'Development')
                                            <i class="fas fa-code"></i>
                                        @elseif ($activity->status == 'Done')
                                            <i class="fas fa-check"></i>
                                        @endif
                                    </div>
                                    <div class="activity-detail">
                                        <div class="mb-2">
                                            <span
                                                class="text-job {{ $loop->first ? 'text-primary' : '' }}">{{ now()->parse(implode('', explode('.000', $activity->created_at)), 'Asia/Jakarta')->longAbsoluteDiffForHumans(now('Asia/Jakarta')->format('Y-m-d H:i:s')) }}</span>
                                        </div>
                                        <p>{{ $activity->description }}</p>
                                    </div>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>
                        Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('modules/dropzonejs/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('modules/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        let interval;
        Dropzone.autoDiscover = false;

        function countdown(counter = parseInt(`{{ $countStartTask }}`)) {
            clearInterval(interval);
            interval = setInterval(() => {
                if (`{{ $task->status }}` == 'Pending') {
                    y = moment(`{{ $task->start_date }} 00:01:01`);
                    x = moment();
                    duration = moment.duration(y.diff(x));
                    $('.time-count').html(
                        `<i class="fas fa-hourglass-end fa-spin"></i> The processing time in ${getMoment('y',duration)} ${getMoment('M',duration)} ${getMoment('d',duration)} ${getMoment('h', duration)} ${getMoment('m',duration)} ${getMoment('s',duration)} from now`
                    )
                } else if (`{{ $task->status }}` == 'Progress') {
                    y = moment(`{{ $task->deadline_date }} 23:59:59`);
                    x = moment();
                    duration = moment.duration(y.diff(x));
                    let status = '<i class="fas fa-upload"></i> Upload';
                    if (counter == 0) {
                        status = '<i class="fas fa-play"></i> Start'
                    }
                    let countdown =
                        `${status} before ${getMoment('y',duration)} ${getMoment('M',duration)} ${getMoment('d',duration)} ${getMoment('h', duration)} ${getMoment('m',duration)} ${getMoment('s',duration)} from now`;
                    $('.count-time-form').html(`${countdown}`);
                    $('.time-count').html(countdown);
                } else if (`{{ $task->status }}` == 'End') {
                    y = moment(`{{ $task->deadline_date }} 23:59:59`);
                    x = moment();
                    duration = moment.duration(y.diff(x));
                    $('.time-count').html(
                        `<i class="far fa-calendar-times"></i> The processing time is up in ${getMoment('y',duration)} ${getMoment('M',duration)} ${getMoment('d',duration)} ${getMoment('h', duration)} ${getMoment('m',duration)} ${getMoment('s',duration)} ago`
                    );
                }
                let tasks = JSON.parse(`<?php echo $task->allFile; ?>`);
                tasks.forEach((task, index) => {
                    y = moment(task.created_at.split('T').join(
                        ' ').split('.000000Z').join(''));
                    x = moment();
                    duration = moment.duration(y.diff(x));
                    $($('.task-collection')[index]).html(
                        `Task collection on ${getMoment('y',duration, true)} ${getMoment('M',duration, true)} ${getMoment('d',duration, true)} ${getMoment('h', duration, true)} ${getMoment('m',duration, true)} ${getMoment('s',duration, true)} ago`
                    );
                });
            }, 1000);
        }

        function showFormStoreTask() {
            $.ajax({
                type: "GET",
                url: `{{ route('database.task.progress', $task->id) }}`,
                dataType: "json",
                success: function(response) {
                    if (response.data.status != 'Development') {
                        if (response.data.status == "Started") {
                            $('input[name=status]').val('Analysis');
                            $('input[name=progress]').val(40);
                            $('input[name=start]').val(response.data.start);
                        } else if (response.data.status == "Analysis") {
                            $('input[name=status]').val('Development');
                            $('input[name=progress]').val(80);
                            $('input[name=start]').val(response.data.start);
                        }
                        $('#modal-activity-task').modal('show');
                    } else {
                        $('#modal-store-task').modal('show');
                    }
                }
            });
        }

        function showAllFilesUploaded() {
            $('#modal-all-task-file').modal('show');
        }

        function storeTask() {
            $.ajax({
                type: "POST",
                url: `{{ route('user.todo.store') }}`,
                data: new FormData($('#form-store-task')[0]),
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    $('#modal-store-task').modal('hide');
                    $('.time-count').attr('disabled', true)
                },
                error: function(error) {
                    $('#save-file-task').removeClass('disabled');
                    $('button[data-dissmis=modal]').removeClass('disabled');
                    alertClose();
                }
            });
        }

        function updateactivityTask() {
            $.ajax({
                type: "POST",
                url: `{{ route('user.todo.activity-update') }}`,
                data: new FormData($('#form-update-activity')[0]),
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    $('#modal-activity-task').modal('hide');
                },
                error: function(error) {
                    $('#update-activity-task').removeClass('disabled');
                    $('button[data-dissmis=modal]').removeClass('disabled');
                    alertClose();
                }
            });
        }

        function startTask() {
            swal("Are you sure you want to start this task?", {
                icon: 'info',
                buttons: ["Cancel", "Start Task!"],
            }).then((click) => {
                if (click) {
                    $.ajax({
                        type: "POST",
                        url: `{{ route('user.todo.start') }}`,
                        headers: {
                            "X-CSRF-TOKEN": `{{ csrf_token() }}`
                        },
                        data: {
                            user_id: `{{ session('auth.id') }}`,
                            task_id: `{{ $task->id }}`,
                            status: `Started`,
                            description: `{{ session('auth.first_name') . ' ' . session('auth.last_name') }} start task {{ $task->title }}`,
                        },
                        dataType: "json",
                        success: function(response) {
                            swal(response.message, {
                                icon: 'success',
                            });
                            $('.article-cta').html(
                                `<button type="button" onclick="showFormStoreTask()" class="btn btn-success time-count"></button>`
                            );
                            countdown(1);
                        },
                        error: function(error) {
                            alertClose();
                        }
                    });
                }
            });
        }
        $(function() {
            let myDropzone = new Dropzone("#dropzone", {
                url: `{{ route('user.todo.store') }}`,
                method: "POST",
                paramName: 'file',
                acceptedFiles: '.zip',
                addRemoveLinks: true,
                maxFiles: 1,
                timeout: -1,
                autoProcessQueue: false,
                maxFilesize: 100,
                headers: {
                    "X-CSRF-TOKEN": `{{ csrf_token() }}`
                }
            });
            let activityDropzone = new Dropzone("#activity-dropzone", {
                url: `{{ route('user.todo.activity-update') }}`,
                method: "POST",
                paramName: 'activity_photos',
                acceptedFiles: '.png, .jpeg, .jpg',
                addRemoveLinks: true,
                maxFiles: 1,
                timeout: -1,
                autoProcessQueue: false,
                maxFilesize: 5,
                headers: {
                    "X-CSRF-TOKEN": `{{ csrf_token() }}`
                }
            });
            $('#save-file-task').click(function() {
                alertLoading();
                $(this).addClass('disabled');
                $('button[data-dissmis=modal]').addClass('disabled');
                if (myDropzone.getQueuedFiles().length > 0) {
                    let file_upload = new Promise((resolve, reject) => {
                        myDropzone.processQueue();
                        myDropzone.on("success", function(file) {
                            myDropzone.removeFile(file);
                            return resolve(true)
                        });
                    })
                    file_upload.then((done) => {
                        storeTask();
                        $('#save-file-task').removeClass('disabled');
                        $('button[data-dissmis=modal]').removeClass('disabled');
                        alertClose();
                    });
                } else {
                    if ($('[name=link]').val() == '') {
                        swal('Please choose, You will collect tasks using what, link or file', {
                            icon: 'error'
                        });
                        return
                    }
                    storeTask();
                }
            });
            $('#update-activity-task').click(function() {
                alertLoading();
                $(this).addClass('disabled');
                $('button[data-dissmis=modal]').addClass('disabled');
                if (activityDropzone.getQueuedFiles().length > 0) {
                    let file_upload = new Promise((resolve, reject) => {
                        activityDropzone.processQueue();
                        activityDropzone.on("success", function(file, response) {
                            $('[name=extension]').val(response.extension)
                            activityDropzone.removeFile(file);
                            return resolve(true)
                        });
                    })
                    file_upload.then((done) => {
                        updateactivityTask();
                        $('#update-activity-task').removeClass('disabled');
                        $('button[data-dissmis=modal]').removeClass('disabled');
                        alertClose();
                    });
                } else {
                    updateactivityTask();
                }
            });
            countdown();
        });
    </script>
@endsection
