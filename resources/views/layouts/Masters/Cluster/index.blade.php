@extends('main')
@section('content')
    <div class="row justify-content-start justify-content-md-end mb-2">
        <div class="col-sm-3">
            <button type="button" id="create-new-cluster" class=" btn btn-success">Create New Cluster</button>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4>List Of Cluster</h4>
            <div class="card-header-form">
                <form>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search">
                        <div class="input-group-btn">
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nomer</th>
                            <th>Nama</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clusters as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td>
                                    <button data-id="{{ $item->id }}" type="button"
                                        class="btn btn-warning mt-1 edit"><i class="fas fa-pen"></i>
                                        Edit</button>
                                    <button type="button" class="btn btn-danger mt-1 delete"><i class="fas fa-trash"></i>
                                        Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Data Not Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('modals')
    <div class="modal fade" id="modal-create-cluster" tabindex="-1" role="dialog" data-keyboard='false'
        data-backdrop="static" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Create New Student Cluster</h5>
                </div>
                <div class="modal-body">
                    <form id="form-cluster">
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input name='name' type="text" class="form-control">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name='description' class="form-control"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>
                        Close</button>
                    <button id="save-cluster" type="button" class="btn btn-success"><i class="fas fa-save"></i> Save
                        Cluster</button>
                    <button id="update-cluster" type="button" class="btn btn-warning d-none"><i class="fas fa-pen"></i>
                        Update Cluster</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('modules/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $(function() {
            $('#create-new-cluster').click(function() {
                $('#modal-create-cluster').modal('show')
                $('#save-cluster').removeClass('d-none');
                $('#update-cluster').addClass('d-none');
            });
            $('.edit').click(function() {
                $('#modal-create-cluster').modal('show');
                $('#save-cluster').addClass('d-none');
                $('#update-cluster').removeClass('d-none');
                let id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: `{{ route('master.cluster.show') }}/${id}`,
                    dataType: "JSON",
                    beforeSend: function() {
                        swal('Loading');
                    },
                    success: function(response) {
                        swal.close()
                        swal(response.message, {
                            icon: 'success'
                        });
                        $.each(response.data, function(index, data) {
                            $(`[name=${index}]`).val(data);
                        });
                        setTimeout(() => {
                            swal.close()
                        }, 150);
                        $('#update-cluster').data('id', response.data.id)
                    },
                    error: function(error) {
                        swal.close();
                        let errors = error.responseJSON.errors
                        if (errors != undefined) {
                            $.each(errors, function(index, error_list) {
                                let html = ``;
                                error_list.forEach(element => {
                                    html +=
                                        `<li class="list-group-item border-0">${element}</li>`;
                                });
                                $(`[name=${index}]`).addClass('is-invalid')
                                    .siblings('.invalid-feedback').html(html);
                            });
                        }
                    }
                });
            });
            $('#update-cluster').click(function() {
                $('.is-invalid').removeClass('is-invalid')
                let form_data = serializeObject($('#form-cluster'));
                let id = $(this).data('id');
                $.ajax({
                    type: "PUT",
                    url: `{{ route('master.cluster.update') }}/${id}`,
                    data: form_data,
                    dataType: "JSON",
                    beforeSend: function() {
                        swal('Loading');
                    },
                    success: function(response) {
                        swal.close();
                        $('#modal-create-cluster').modal('hide')
                        swal(response.message, {
                            icon: 'success'
                        });
                        setTimeout(() => {
                            swal.close()
                            location.reload()
                        }, 1500);
                    },
                    error: function(error) {
                        swal.close();
                        let errors = error.responseJSON.errors
                        if (errors != undefined) {
                            $.each(errors, function(index, error_list) {
                                let html = ``;
                                error_list.forEach(element => {
                                    html +=
                                        `<li class="list-group-item border-0">${element}</li>`;
                                });
                                $(`[name=${index}]`).addClass('is-invalid')
                                    .siblings('.invalid-feedback').html(html);
                            });
                        }
                    }
                });
            });
            $('#save-cluster').click(function() {
                $('.is-invalid').removeClass('is-invalid')
                let form_data = serializeObject($('#form-cluster'));
                $.ajax({
                    type: "POST",
                    url: `{{ route('master.cluster.store') }}`,
                    data: form_data,
                    dataType: "JSON",
                    beforeSend: function() {
                        swal('Loading');
                    },
                    success: function(response) {
                        swal.close();
                        $('#modal-create-cluster').modal('hide')
                        swal(response.message, {
                            icon: 'success'
                        });
                        setTimeout(() => {
                            swal.close()
                            location.reload()
                        }, 1500);
                    },
                    error: function(error) {
                        swal.close();
                        let errors = error.responseJSON.errors
                        if (errors != undefined) {
                            $.each(errors, function(index, error_list) {
                                let html = ``;
                                error_list.forEach(element => {
                                    html +=
                                        `<li class="list-group-item border-0">${element}</li>`;
                                });
                                $(`[name=${index}]`).addClass('is-invalid')
                                    .siblings('.invalid-feedback').html(html);
                            });
                        }
                    }
                });
            });
            $('#modal-create-cluster').on('hidden.bs.modal', function() {
                $('.alert-danger').addClass('d-none');
                $(".alert-body").html(``);
                $('input[name=name]').removeClass('is-invalid').val('');
                $('textarea[name=description]').removeClass('is-invalid').val('');
            });
        });
    </script>
@endsection
