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
                    </div>
                </div>
                <div class="article-details">
                    <p>{!! $task->content !!}</p>
                    <div class="article-cta">
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </article>
        </div>
    </div>
@endsection
