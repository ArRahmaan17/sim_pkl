@extends('main')
@section('css')
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active can" data-status="All" href="#">All <span
                                    class="badge badge-info">{{ $pendingTasks + $progressTasks + $endTasks }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link can" data-status="Pending" href="#">Pending <span
                                    class="badge badge-warning ">{{ $pendingTasks }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link can" data-status="Progress" href="#">Progress <span
                                    class="badge badge-success">{{ $progressTasks }}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link can" data-status="End" href="#">End <span
                                    class="badge badge-danger">{{ $endTasks }}</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-6 col-md-2">
                        <h4>All Posts</h4>
                    </div>
                    <div class="col-6 col-md-10">
                        <div class="float-right">
                            <Button id="create-task" type="button" class="btn btn-success"><i class="fas fa-plus"></i>
                                Create Task</Button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="float-right">
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search" name="search-task">
                                <div class="input-group-append">
                                    <button onclick="taskListCreateElement()" type="button" class="btn btn-primary"><i
                                            class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="clearfix mb-3"></div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        NO
                                    </th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="float-right">
                        <nav>
                            <ul class="pagination">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modals')
    <div class="modal fade" id="modal-create-task" tabindex="-1" role="dialog" data-keyboard='false'
        data-backdrop="static" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title-create-task">Create New Task</h5>
                </div>
                <div class="modal-body">
                    <form id="create-new-task" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="title">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Start Task</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="start_date" class="form-control datepicker-start">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deadline</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="deadline_date" class="form-control datepicker-end">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Group</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control" name="group[]" multiple="" data-height="100%">
                                    @foreach ($clusters as $cluster)
                                        <option value="{{ $cluster->id }}">{{ $cluster->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Content</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="form-control" name="content"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Thumbnail</label>
                            <div class="col-sm-12 col-md-7">
                                <div id="image-preview" class="image-preview">
                                    <label for="image-upload" id="image-label">Choose File</label>
                                    <input type="file" name="image" id="image-upload" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="status" class="form-control" readonly>
                                <small id="emailHelp" class="form-text text-warning">
                                    it will fill automaticlly after you set deadline </small>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>
                        Close</button>
                    <button id="save-task" type="button" class="btn btn-success"><i class="fas fa-save"></i> Create
                        Task</button>
                    <button id="update-task" type="button" class="btn btn-warning d-none"><i class="fas fa-pen"></i>
                        Update Task</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-view-task" tabindex="-1" role="dialog" data-keyboard='false'
        data-backdrop="static" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title-view-task">View Task</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group row mb-4">
                        <label class="text-md-right col-12 col-md-3 col-lg-3">Title</label>
                        <div class="col-sm-12 col-md-7" data-index="title">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="text-md-right col-12 col-md-3 col-lg-3">Start Task</label>
                        <div class="col-sm-12 col-md-7" data-index="start_date">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="text-md-right col-12 col-md-3 col-lg-3">Group</label>
                        <div class="col-sm-12 col-md-7" data-index="group">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="text-md-right col-12 col-md-3 col-lg-3">Content</label>
                        <div class="col-sm-12 col-md-7" data-index="content">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="text-md-right col-12 col-md-3 col-lg-3">Thumbnail</label>
                        <div class="col-sm-12 col-md-7" data-index="thumbnail">
                        </div>
                    </div>
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
    <script src="{{ asset('modules/moment.min.js') }}"></script>
    <script src="{{ asset('modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
    <script src="{{ asset('js/page/features-post-create.js') }}"></script>
    <script src="{{ asset('modules/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        var endElement = $('.datepicker-end');
        var startElement = $('.datepicker-start');

        function taskListCreateElement(data = {
            'indexPage': 0,
            'search': $('[name=search-task]').val(),
            'status': $('.can.active').data('status'),
        }) {
            swal('Loading', {
                button: false,
                icon: `{{ asset('img/loading.gif') }}`
            });
            let datas = window.tasks;
            let rowTable = ``;
            let group = '';
            let clusters = JSON.parse(`<?php echo $clusters; ?>`);
            let status = '';
            if (datas[data.indexPage].length == undefined) {
                datas[data.indexPage] = Object.values(datas[data.indexPage])
            }
            datas[data.indexPage].forEach((element, index) => {
                let group = '';
                let groups = JSON.parse(`${element.group}`);
                groups.forEach(value => {
                    clusters.forEach(cluster => {
                        if (value == cluster.id) {
                            group += `<a href="#">${cluster.name}</a> `;
                        }
                    });
                });
                let status = '';
                if (element.status == "Pending") {
                    status = `<div class="badge badge-warning">${element.status}</div>`;
                } else if (element.status == "Progress") {
                    status = `<div class="badge badge-success">${element.status}</div>`;
                } else {
                    status = `<div class="badge badge-danger">${element.status}</div>`;
                }
                if (element.title.toLowerCase().split(data.search).length == 1) {
                    return
                }
                if (data.status != "All") {
                    if (data.status != element.status) {
                        return;
                    }
                }
                rowTable += `<tr>
                    <td>
                        ${ (index + 1) + (data.indexPage*5)}
                    </td>
                    <td>${element.title}
                        <div class="table-links">
                            <a href="#" class="text-primary detail"
                                data-id="${element.id}">View</a>
                            <div class="bullet"></div>
                            <a href="#" class="text-warning edit"
                                data-id="${element.id}">Edit</a>
                            <div class="bullet"></div>
                            <a href="#" class="text-danger delete"
                                data-id="${element.id}">Trash</a>
                        </div>
                    </td>
                    <td>
                        ${group}
                    </td>
                    <td>${moment(element.created_at).format('YYYY-MM-DD HH:mm:ss')}</td>
                    <td>
                        ${status}
                    </td>
                </tr>`;
            })
            $('tbody').html(rowTable);
            let center = ``;
            for (let index = 0; index < (data.status == "All" ?
                    `{{ $pendingTasks + $progressTasks + $endTasks }}` : (data.status == "Pending") ?
                    `{{ $pendingTasks }}` : (data.status == "Progress") ?
                    `{{ $progressTasks }}` : (data.status == "End") ?
                    `{{ $endTasks }}` : 0); index++) {
                if (index == data.indexPage || index == (data.indexPage - 1) || index == (data.indexPage + 1)) {
                    center += `<li class="page-item ${index == data.indexPage ? 'active' : ''}">
                    <a class="page-link" onclick="taskListCreateElement(${index})">${index+1}</a>
                </li>`
                }
            }
            let pagination = `<li class="page-item ${data.indexPage == 0 ? 'disabled': ''}">
                    <a class="page-link" href="#" aria-label="Previous" onclick="taskListCreateElement(${data.indexPage-1})">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                ${center}
                <li class="page-item ${data.indexPage == (window.tasks.length-1) ? 'disabled' : ''}">
                    <a class="page-link" href="#" aria-label="Next" onclick="taskListCreateElement(${data.indexPage+1})">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>`;
            $('.pagination').html(pagination);
            $('.edit').click(function() {
                let id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: `{{ route('mentor.task.show') }}/${id}`,
                    dataType: "JSON",
                    success: function(response) {
                        swal(response.message, {
                            'icon': 'success'
                        }).then((click) => {
                            $('#modal-create-task').modal('show');
                            setTimeout(() => {
                                $('#save-task').addClass('d-none')
                                $('#update-task').removeClass(
                                        'd-none')
                                    .data(
                                        'id', response
                                        .data.id)
                                let group = JSON.parse(
                                    `<?php echo $clusters; ?>`);
                                $("#title-create-task")
                                    .html(
                                        `Update Task ${response.data.title}`
                                    );
                                $.each(response.data, function(
                                    indexInArray,
                                    valueOfElement) {
                                    if (indexInArray ==
                                        "group") {
                                        JSON.parse(
                                                valueOfElement
                                            )
                                            .forEach(
                                                value => {
                                                    $(`[name="group[]"]`)
                                                        .find(
                                                            `option[value=${value}]`
                                                        )
                                                        .attr(
                                                            'selected',
                                                            true
                                                        )
                                                })
                                    } else if (
                                        indexInArray ==
                                        'thumbnail') {
                                        $('#image-preview')
                                            .css(
                                                "background-size",
                                                'cover')
                                            .css(
                                                'background-image',
                                                `url(data:image/png;base64,${valueOfElement})`
                                            )
                                            .css(
                                                'background-position',
                                                `center center`
                                            );
                                    } else {
                                        if (indexInArray ==
                                            'start_date' ||
                                            indexInArray ==
                                            'deadline_date'
                                        ) {
                                            if (indexInArray ==
                                                'start_date'
                                            ) {
                                                startElement
                                                    .data(
                                                        'daterangepicker'
                                                    )
                                                    .setStartDate(
                                                        valueOfElement
                                                    )
                                            }
                                            $(`[name="${indexInArray}"]`)
                                                .val(
                                                    `${valueOfElement}`
                                                )
                                                .trigger(
                                                    'apply.daterangepicker'
                                                );
                                        } else {
                                            $(`[name="${indexInArray}"]`)
                                                .val(
                                                    `${valueOfElement}`
                                                );
                                        }
                                    }
                                });
                            }, 400);
                        });
                    },
                    error(error) {
                        swal(error.responseJSON.message, {
                            'icon': 'error'
                        });
                    }
                });
            });
            $('.detail').click(function() {
                let id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: `{{ route('mentor.task.show') }}/${id}`,
                    dataType: "JSON",
                    success: function(response) {
                        swal(response.message, {
                            'icon': 'success'
                        }).then((click) => {
                            let group = JSON.parse(`<?php echo $clusters; ?>`);
                            $("#title-view-task")
                                .html(
                                    `View Task ${response.data.title} <div class="badge badge-warning">${response.data.status}</div>`
                                );
                            $.each(response.data, function(indexInArray,
                                valueOfElement) {
                                if (indexInArray == 'group') {
                                    $(`[data-index="${indexInArray}"]`)
                                        .html('')
                                    group.forEach(element => {
                                        JSON.parse(
                                                valueOfElement
                                            )
                                            .forEach(
                                                group => {
                                                    if (element
                                                        .id ==
                                                        group
                                                    ) {
                                                        $(`[data-index="${indexInArray}"]`)
                                                            .append(
                                                                `<a href="#">${element.name}</a> `
                                                            );
                                                    }
                                                });
                                    });
                                } else if (indexInArray ==
                                    'thumbnail') {
                                    $(`[data-index="${indexInArray}"]`)
                                        .html(
                                            `<img class="img-thumbnail" src="data:image/png;base64,${valueOfElement}" class="img-fluid">`
                                        );
                                } else if (indexInArray ==
                                    'start_date') {
                                    let dayLeft = moment(
                                            valueOfElement)
                                        .diff(
                                            moment(), 'days');
                                    let deadline;
                                    if (dayLeft == 0) {
                                        deadline = moment(
                                                valueOfElement)
                                            .diff(
                                                moment(
                                                    response.data
                                                    .deadline_date
                                                ), 'hours')
                                    }
                                    $(`[data-index="${indexInArray}"]`)
                                        .html(
                                            `Start in ${dayLeft} Days${deadline == undefined ? '' : `, DeadLine on ${deadline == 0 ? 'this day' : `${deadline} Days`}` }`
                                        );
                                } else {
                                    $(`[data-index="${indexInArray}"]`)
                                        .html(`${valueOfElement}`);
                                }
                            });
                            $('#modal-view-task').modal('show');
                        });

                    },
                    error(error) {
                        swal(error.responseJSON.message, {
                            'icon': 'error'
                        });
                    }
                });
            });
            $('.delete').click(function() {
                swal("Are you sure want to delete this task?", {
                    dangerMode: true,
                    buttons: true,
                }).then((click) => {
                    if (click) {
                        let id = $(this).data('id');
                        $.ajax({
                            type: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': `{{ csrf_token() }}`
                            },
                            url: `{{ route('mentor.task.delete') }}/${id}`,
                            dataType: "json",
                            success: function(response) {
                                window.tasks = response.data;
                                taskListCreateElement();
                            }
                        });
                    }
                });
            });
            setTimeout(() => {
                swal.close();
            }, 500);
        }
        $.ajax({
            type: "GET",
            url: "{{ route('database.task.all') }}",
            dataType: "JSON",
            success: function(response) {
                window.tasks = response.data;
            }
        }).then(() => {
            $(function() {
                taskListCreateElement();
                $('#modal-create-task').on('shown.bs.modal', function() {
                    startElement.daterangepicker({
                        locale: {
                            format: 'YYYY-MM-DD',
                            language: "ID",
                            "daysOfWeek": [
                                "Min",
                                "Sen",
                                "Sel",
                                "Rab",
                                "Kam",
                                "Jum",
                                "Sab"
                            ],
                            "monthNames": [
                                "Januari",
                                "Februari",
                                "Maret",
                                "April",
                                "Mei",
                                "Juni",
                                "Juli",
                                "Augustus",
                                "September",
                                "Oktober",
                                "Nopember",
                                "Desember"
                            ],
                        },
                        'drops': 'auto',
                        "autoApply": true,
                        'startDate': `{{ $startDate }}`,
                        'maxDate': `{{ $endDate }}`,
                        'minDate': `{{ $startDate }}`,
                        'parentEl': '#modal-create-task',
                        'singleDatePicker': true,
                    });
                });
                startElement.on('apply.daterangepicker', function() {
                    if (moment().format('YYYY-MM-DD') == $(this).val()) {
                        $('[name=status]').val('Progress');
                    } else {
                        $('[name=status]').val('Pending');
                    }
                    endElement.daterangepicker({
                        locale: {
                            format: 'YYYY-MM-DD',
                            "daysOfWeek": [
                                "Min",
                                "Sen",
                                "Sel",
                                "Rab",
                                "Kam",
                                "Jum",
                                "Sab"
                            ],
                            "monthNames": [
                                "Januari",
                                "Februari",
                                "Maret",
                                "April",
                                "Mei",
                                "Juni",
                                "Juli",
                                "Augustus",
                                "September",
                                "Oktober",
                                "Nopember",
                                "Desember"
                            ],
                        },
                        'drops': 'auto',
                        "autoApply": true,
                        'startDate': $(this).val(),
                        'maxDate': `{{ $endDate }}`,
                        'minDate': $(this).val(),
                        'parentEl': '#modal-create-task',
                        'singleDatePicker': true,
                    });
                });
                $('.can').click(function() {
                    $('.can').removeClass('active');
                    $(this).addClass('active');
                    setTimeout(() => {
                        taskListCreateElement();
                    }, 300);
                });

                $('#modal-create-task').on('hidden.bs.modal', function() {
                    $('#create-new-task')[0].reset();
                    $('#image-preview').removeAttr('style');
                });
                $('#create-task').click(function() {
                    $('#modal-create-task').modal('show');
                });
                $('#save-task').click(function() {
                    $.ajax({
                        type: "post",
                        url: "{{ route('mentor.task.store') }}",
                        data: new FormData($('#create-new-task')[0]),
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            swal(response.message, {
                                'icon': 'success'
                            });
                            $('#create-new-task')[0].reset();
                            $('#image-preview').removeAttr('style');
                            $('#modal-create-task').modal('hide');
                            window.tasks = response.data;
                            taskListCreateElement();
                        },
                        error: function(error) {
                            if (error.responseJSON.errors != undefined) {
                                let errors = error.responseJSON.errors;
                                $.each(errors, function(indexInArray,
                                    valueOfElement) {
                                    if (indexInArray == 'group') {
                                        $(`[name="${indexInArray}[]"]`)
                                            .addClass('is-invalid')
                                            .siblings('.invalid-feedback')
                                            .html(`${valueOfElement}`);
                                    } else {
                                        $(`[name=${indexInArray}]`)
                                            .addClass('is-invalid')
                                            .siblings('.invalid-feedback')
                                            .html(`${valueOfElement}`);
                                    }
                                });
                            } else {
                                swal(error.responseJSON.message, {
                                    'icon': 'error'
                                });
                            }
                        }
                    });
                });
                $('#update-task').click(function() {
                    let id = $(this).data('id')
                    $.ajax({
                        type: "POST",
                        url: `{{ route('mentor.task.update') }}/${id}`,
                        data: new FormData($('#create-new-task')[0]),
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            swal(response.message, {
                                'icon': 'success'
                            });
                            $('#create-new-task')[0].reset();
                            $('#image-preview').removeAttr('style');
                            $('#modal-create-task').modal('hide');
                            window.tasks = response.data;
                            taskListCreateElement();
                        },
                        error: function(error) {
                            if (error.responseJSON.errors != undefined) {
                                let errors = error.responseJSON.errors;
                                $.each(errors, function(indexInArray,
                                    valueOfElement) {
                                    if (indexInArray == 'group') {
                                        $(`[name="${indexInArray}[]"]`)
                                            .addClass('is-invalid')
                                            .siblings('.invalid-feedback')
                                            .html(`${valueOfElement}`);
                                    } else {
                                        $(`[name=${indexInArray}]`)
                                            .addClass('is-invalid')
                                            .siblings('.invalid-feedback')
                                            .html(`${valueOfElement}`);
                                    }
                                });
                            } else {
                                swal(error.responseJSON.message, {
                                    'icon': 'error'
                                });
                            }
                        }
                    });
                });
            });
        });
    </script>
@endsection
