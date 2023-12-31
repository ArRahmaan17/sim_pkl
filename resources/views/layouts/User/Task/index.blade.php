@extends('main')
@section('content')
    <h2 class="section-title">Your Task</h2>
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-9">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active can" data-status="All" href="#"><i
                                            class="fas fa-list"></i>
                                        All
                                        <span
                                            class="badge badge-info">{{ $pendingTasks + $progressTasks + $endTasks }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link can" data-status="Pending" href="#"><i
                                            class="fas fa-pause"></i>
                                        Pending <span class="badge badge-warning ">{{ $pendingTasks }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link can" data-status="Progress" href="#"><i
                                            class="fas fa-spinner"></i>
                                        Progress <span class="badge badge-success">{{ $progressTasks }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link can" data-status="End" href="#"><i class="fas fa-lock"></i> End
                                        <span class="badge badge-danger">{{ $endTasks }}</span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="float-md-right">
                                <form>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="search-task">
                                        <div class="input-group-append">
                                            <button onclick="taskListCreateElement()" type="button"
                                                class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2" id="container-tasks">
    </div>
    <div class="card mb-0 pt-3">
        <div class="card-body m-0 p-0">
            <div class="float-left">
                <h2 class="px-1">List Of Your Task</h2>
            </div>
            <div class="float-right">
                <nav>
                    <ul class="pagination">
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('modules/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        function checkCountSearch(search, status) {
            window.tasks.forEach((element, index) => {
                if (element.length == undefined) {
                    window.tasks[index] = Object.values(window.tasks[index])
                }
            })
            let tasks = window.tasks.flat(2);
            let count = 0;
            tasks.forEach((element, index) => {
                if (status == 'All') {
                    if (element.title.toLowerCase().split(search.toLowerCase()).length > 1) {
                        count++;
                    }
                } else {
                    if (element.title.toLowerCase().split(search.toLowerCase()).length > 1 && element.status ==
                        status) {
                        count++;
                    }
                }
            });
            return count;
        }

        function taskListCreateElement(data = {
            'indexPage': 0,
            'search': $('[name=search-task]').val(),
            'status': $('.can.active').data('status'),
        }) {
            alertLoading()
            if (window.tasks != undefined && window.tasks != []) {
                if (window.tasks[data.indexPage] != undefined) {
                    let datas = window.tasks;
                    let elementTasks = ``;
                    let group = '';
                    let status = '';
                    let searchcount = 0;
                    if (data.search != '') {
                        let dataTask = window.tasks.flat(2);
                        dataTask = dataTask.filter(element => {
                            return element.title.toLowerCase().split(data.search.toLowerCase()).length > 1
                        });
                        datas = chunkArray(dataTask)
                    }
                    if (datas.length == 0) {
                        setTimeout(() => {
                            alertClose();
                        }, 500);
                        $('#container-tasks').html(elementTasks);
                        return
                    }
                    datas[data.indexPage].forEach((element, index) => {
                        let status = '';
                        if (element.status == "Pending") {
                            status =
                                `<div class="text-warning"><span class="text-dark">Task status :</span> ${element.status}</div>`;
                        } else if (element.status == "Progress") {
                            status =
                                `<div class="text-success"><span class="text-dark">Task status :</span> ${element.status}</div>`;
                        } else {
                            status =
                                `<div class="text-danger"><span class ="text-dark">Task status :</span> ${element.status}</div>`;
                        }
                        if (data.status != "All") {
                            if (data.status != element.status) {
                                return;
                            }
                        }
                        let more_element = ''
                        if (`{{ session('auth.role') }}` == "S") {
                            if (element.last_activity != undefined) {
                                let class_progress = '';
                                if (element.last_activity.progress == '0') {
                                    class_progress = 'bg-dark';
                                } else if (element.last_activity.progress == '10') {
                                    class_progress = 'bg-danger';
                                } else if (element.last_activity.progress == '40') {
                                    class_progress = 'bg-warning';
                                } else if (element.last_activity.progress == '80') {
                                    class_progress = 'bg-info';
                                } else if (element.last_activity.progress == '100') {
                                    class_progress = 'bg-success';
                                }
                                more_element = `<p class="text-muted">your task progress</p>
                                        <div class="progress mb-3">
                                            <div class="progress-bar ${class_progress}" role="progressbar" style="width:${element.last_activity.progress}%">${element.last_activity.progress}%</div>
                                        </div>`
                            }
                        }
                        elementTasks += `<div class="col-12 col-md-4 col-lg-4">
                                            <article class="article article-style-c">
                                                <div class="article-header">
                                                    <div class="article-image" style='background-image: url("data:image/png;base64,${element.thumbnail}"); background-size:cover; background-position: center center;' >
                                                    </div>
                                                </div>
                                                <div class="article-details">
                                                    <div class="article-category">
                                                        <div class="bullet"></div>
                                                        <a>${moment(moment(element.created_at.split('.000000Z').join('').split('T').join(' ')).format('YYYY-MM-DD HH:mm:ss')).fromNow()}</a>
                                                    </div>
                                                    <div class="article-user">
                                                        <p><a href="{{ route('user.todo.show') }}/${element.id}">${element.title}</a></p>
                                                        <div class="article-user-details">
                                                            <div>${status}</div>
                                                            ${more_element}
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                    </div>`;
                    });
                    $('#container-tasks').html(elementTasks);
                    let center = ``;
                    searchcount = checkCountSearch(data.search.toLowerCase(), data.status);
                    if (searchcount != 0) {
                        for (let index = 0; index < ((searchcount <= 5) ? 1 : ((searchcount / 5).toString().split('.')
                                .length ==
                                1) ? Math.floor(searchcount / 5) : Math.floor(searchcount / 5) + 1); index++) {
                            if (index == data.indexPage || index == (data.indexPage - 1) || index == (data.indexPage + 1)) {
                                center += `<li class="page-item ${index == data.indexPage ? 'active' : ''}">
                                            <a class="page-link" onclick="taskListCreateElement({'indexPage': ${index},'search': $('[name=search-task]').val(),'status': $('.can.active').data('status')})">${index+1}</a>
                                       </li>`
                            }
                        }
                    }
                    let pagination = `<li class="page-item ${data.indexPage == 0 ? 'disabled': ''}">
                                            <a class="page-link" href="#" aria-label="Previous" onclick="taskListCreateElement({'indexPage': ${data.indexPage-1},'search': $('[name=search-task]').val(),'status': $('.can.active').data('status')})">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        ${center}
                                        <li class="page-item ${data.indexPage == ((searchcount <= 5) ? 0 : (data.search != "") ?Math.floor(searchcount / 5)-1:Math.floor(searchcount / 5)) ? 'disabled' : ''}">
                                            <a class="page-link" href="#" aria-label="Next" onclick="taskListCreateElement({'indexPage': ${data.indexPage+1},'search': $('[name=search-task]').val(),'status': $('.can.active').data('status')})">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>`;
                    $('.pagination').html(pagination);
                }
            }
            setTimeout(() => {
                alertClose();
            }, 500);
        }

        function ready() {
            $(function() {
                taskListCreateElement();
                $('.can').click(function() {
                    $('.can').removeClass('active');
                    $(this).addClass('active');
                    taskListCreateElement();
                })
            });
        }
        $.ajax({
            type: "GET",
            url: `{{ route('database.task.user', [session('auth.role'), session('auth.cluster_id') ?? 0]) }}`,
            dataType: "json",
            success: function(response) {
                window.tasks = chunkResolver(response.data);
            },
            error: function(error) {
                window.tasks = chunkResolver(error.responseJSON.data);
            }
        }).then(() => {
            ready()
        }).catch(() => {
            ready()
        });
    </script>
@endsection
