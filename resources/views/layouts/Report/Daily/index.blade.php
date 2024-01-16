@extends('main')
@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="d-flex justify-content-start justify-content-md-end align-items-center flex-wrap">
                    <div class="col-12 col-md-8 py-2 h1 text-center text-md-left">Daily Progress</div>
                    <div class="col-12 col-md-4"><button id="create-daily-progress" type="button"
                            class="btn btn-success col"><i class="fas fa-plus"></i> Create
                            Your Daily Progress</button></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Day</th>
                                    <th>Evindance file</th>
                                    <th>Text</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dailyProgress as $progress)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $progress->day }}</td>
                                        <td><img src="data:image/*;base64,{{ $progress->evidence_file }}" alt="">
                                        </td>
                                        <td>{{ $progress->description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('modals')
    <div class="modal fade" id="modal-progress-daily" tabindex="-1" role="dialog" data-keyboard='false'
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
                        <input type="hidden" name="task_id" value="">
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
@endsection
@section('script')
    <script src="{{ asset('modules/dropzonejs/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('modules/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {
            $('#create-daily-progress').click(function() {
                $('#modal-progress-daily').modal('show')
            })
        });
    </script>
@endsection
