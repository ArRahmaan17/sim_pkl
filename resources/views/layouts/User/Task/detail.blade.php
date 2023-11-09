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
                            <button type="button" onclick="showFormStoreTask()" class="btn btn-success time-count"><i
                                    class="fas fa-upload"></i> Upload
                                before
                                {{ now()->parse(now()->parse($task->deadline_date . ' 23:59:59', 'Asia/Jakarta')->format('Y-m-d H:i:s'))->longRelativeDiffForHumans(now('Asia/Jakarta')->format('Y-m-d H:i:s')) }}</button>
                        @elseif ($task->status == 'End')
                            <button type="button" class="btn btn-danger disabled time-count"><i
                                    class="far fa-calendar-times"></i> The processing
                                time is up in
                                {{ now()->parse($task->deadline_date . ' 23:59:59', 'Asia/Jakarta')->longRelativeDiffForHumans(now('Asia/Jakarta')->format('Y-m-d H:i:s')) }}</button>
                        @endif
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
                                *please make sure your repository is public
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
@endsection
@section('script')
    <script src="{{ asset('modules/dropzonejs/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('modules/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;

        function showFormStoreTask() {
            $('#modal-store-task').modal('show');
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
                timeout: -1,
                autoProcessQueue: false,
                maxFilesize: 100,
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
                        $(this).removeClass('disabled');
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
                    $(this).removeClass('disabled');
                    $('button[data-dissmis=modal]').removeClass('disabled');
                    alertClose();
                }
            });
            setInterval(() => {
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
                    duration = moment.duration(x.diff(y));
                    let countdown =
                        `<i class="fas fa-upload"></i> Upload before ${getMoment('y',duration)} ${getMoment('M',duration)} ${getMoment('d',duration)} ${getMoment('h', duration)} ${getMoment('m',duration)} ${getMoment('s',duration)} from now`;
                    $('.count-time-form').html(`${countdown}`)
                    $('.time-count').html(countdown);
                } else if (`{{ $task->status }}` == 'End') {
                    y = moment(`{{ $task->deadline_date }} 23:59:59`);
                    x = moment();
                    duration = moment.duration(y.diff(x));
                    $('.time-count').html(
                        `<i class="far fa-calendar-times"></i> The processing time is up in ${getMoment('y',duration)} ${getMoment('M',duration)} ${getMoment('d',duration)} ${getMoment('h', duration)} ${getMoment('m',duration)} ${getMoment('s',duration)} ago`
                    );
                }
            }, 1000);
        });
    </script>
@endsection
