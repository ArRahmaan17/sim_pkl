@extends('main')
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
                            <button type="button" class="btn btn-warning disabled time-count">The processing time in
                                {{ now()->parse($task->start_date . ' 00:01:01', 'Asia/Jakarta')->longRelativeDiffForHumans(now('Asia/Jakarta')->format('Y-m-d H:i:s')) }}</button>
                        @elseif ($task->status == 'Progress')
                            <button type="button" onclick="showFormStoreTask()" class="btn btn-success time-count">Upload
                                before
                                {{ now()->parse($task->deadline_date . ' 23:59:59', 'Asia/Jakarta')->longRelativeDiffForHumans(now('Asia/Jakarta')->format('Y-m-d H:i:s')) }}</button>
                        @elseif ($task->status == 'End')
                            <button type="button" class="btn btn-danger disabled time-count">The processing
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
                    <form id="form-menu">
                        <div class="alert alert-danger create d-none">
                            <div class="alert-title">We Found Some Error</div>
                            <div class="alert-body">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input name='name' type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Icon</label>
                            <input name="icon" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Link</label>
                            <input name="link" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Position</label>
                            <select class="form-control" name="position">
                                <option selected value="S">Sidebar</option>
                                <option value="N">Navbar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Access To</label>
                            <select class="form-control" name="access_to" multiple="" data-height="50%">
                                <option selected value="M">Mentor</option>
                                <option value="S">Student</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>
                        Close</button>
                    <button id="save-menu" type="button" class="btn btn-primary"><i class="fas fa-save"></i> Save
                        Menu</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function showFormStoreTask() {
            $('#modal-store-task').modal('show')
        }
        $(document).ready(function() {
            setInterval(() => {
                if (`{{ $task->status }}` == 'Pending') {
                    y = moment(`{{ $task->start_date }} 00:01:01`);
                    x = moment();
                    duration = moment.duration(y.diff(x));
                    $('.time-count').html(
                        `The processing time in ${getMoment('y',duration)} ${getMoment('M',duration)} ${getMoment('d',duration)} ${getMoment('h', duration)} ${getMoment('m',duration)} ${getMoment('s',duration)} from now`
                    )
                } else if (`{{ $task->status }}` == 'Progress') {
                    y = moment(`{{ $task->deadline_date }} 23:59:59`);
                    x = moment();
                    duration = moment.duration(y.diff(x));
                    let countdown =
                        `Upload before ${getMoment('y',duration)} ${getMoment('M',duration)} ${getMoment('d',duration)} ${getMoment('h', duration)} ${getMoment('m',duration)} ${getMoment('s',duration)} from now`;
                    $('.count-time-form').html(`<i class="fas fa-clock"></i> ${countdown}`)
                    $('.time-count').html(countdown);
                } else if (`{{ $task->status }}` == 'End') {
                    y = moment(`{{ $task->deadline_date }} 23:59:59`);
                    x = moment();
                    duration = moment.duration(y.diff(x));
                    $('.time-count').html(
                        `The processing time is up in ${getMoment('y',duration)} ${getMoment('M',duration)} ${getMoment('d',duration)} ${getMoment('h', duration)} ${getMoment('m',duration)} ${getMoment('s',duration)} ago`
                    );
                }
            }, 1000);
        });
    </script>
@endsection
