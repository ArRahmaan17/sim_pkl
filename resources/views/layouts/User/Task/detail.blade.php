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
                            <a href="#" class="btn btn-warning disabled time-count">The processing time in
                                {{ now()->parse($task->start_date . ' 00:01:01', 'Asia/Jakarta')->longRelativeDiffForHumans(now('Asia/Jakarta')->format('Y-m-d H:i:s')) }}</a>
                        @elseif ($task->status == 'Progress')
                            <a href="#" class="btn btn-success time-count">Upload before
                                {{ now()->parse($task->deadline_date . ' 23:59:59', 'Asia/Jakarta')->longRelativeDiffForHumans(now('Asia/Jakarta')->format('Y-m-d H:i:s')) }}</a>
                        @elseif ($task->status == 'End')
                            <a href="#" class="btn btn-danger disabled time-count">The processing time is up in
                                {{ now()->parse($task->deadline_date . ' 23:59:59', 'Asia/Jakarta')->longRelativeDiffForHumans(now('Asia/Jakarta')->format('Y-m-d H:i:s')) }}</a>
                        @endif
                    </div>
                </div>
            </article>
        </div>
    </div>
@endsection
@section('script')
    <script>
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
                    $('.time-count').html(
                        `Upload before ${getMoment('y',duration)} ${getMoment('M',duration)} ${getMoment('d',duration)} ${getMoment('h', duration)} ${getMoment('m',duration)} ${getMoment('s',duration)} from now`
                    );
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
