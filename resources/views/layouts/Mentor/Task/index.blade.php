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
                            <a class="nav-link active" href="#">All <span class="badge badge-white">5</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Draft <span class="badge badge-primary">1</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Pending <span class="badge badge-primary">1</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Trash <span class="badge badge-primary">0</span></a>
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
                    <div class="float-left">
                        <select class="form-control">
                            <option>Action For Selected</option>
                            <option>Move to Draft</option>
                            <option>Move to Pending</option>
                            <option>Delete Pemanently</option>
                        </select>
                    </div>
                    <div class="float-right">
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
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
                                    <th>Author</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        1
                                    </td>
                                    <td>Laravel 5 Tutorial: Introduction
                                        <div class="table-links">
                                            <a href="#">View</a>
                                            <div class="bullet"></div>
                                            <a href="#">Edit</a>
                                            <div class="bullet"></div>
                                            <a href="#" class="text-danger">Trash</a>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#">Web Developer</a>,
                                        <a href="#">Tutorial</a>
                                    </td>
                                    <td>
                                        <a href="#">
                                            <img alt="image" src="assets/img/avatar/avatar-5.png" class="rounded-circle"
                                                width="35" data-toggle="title" title="">
                                            <div class="d-inline-block ml-1">Rizal Fakhri</div>
                                        </a>
                                    </td>
                                    <td>2018-01-20</td>
                                    <td>
                                        <div class="badge badge-primary">Published</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="float-right">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">Create New Task</h5>
                </div>
                <div class="modal-body">
                    <form id="create-new-task" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="title">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Start Task</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="start_date" class="form-control datepicker-start">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deadline</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="deadline_date" class="form-control datepicker-end">
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
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Content</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="form-control" name="content"></textarea>
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
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>
                        Close</button>
                    <button id="save-task" type="button" class="btn btn-success"><i class="fas fa-save"></i> Create
                        Task</button>
                    <button id="update-cluster" type="button" class="btn btn-warning d-none"><i class="fas fa-pen"></i>
                        Update Task</button>
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
    <script>
        const toBase64 = file => new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = reject;
        });
        $(function() {
            $('#modal-create-task').on('shown.bs.modal', function() {
                $('.datepicker-start').daterangepicker({
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
            $('.datepicker-start').on('apply.daterangepicker', function() {
                console.log(moment().format('YYYY-MM-DD'), $(this).val())
                if (moment().format('YYYY-MM-DD') == $(this).val()) {
                    $('[name=status]').val('Progress');
                } else {
                    $('[name=status]').val('Pending');
                }
                $('.datepicker-end').daterangepicker({
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
            $('.datepicker-end').on('apply.daterangepicker', function() {

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

                    }
                });
            })
        });
    </script>
@endsection
