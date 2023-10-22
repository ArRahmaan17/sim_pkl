@extends('main')
@section('content')
    <div class="col-12">
        <div class="row justify-content-start justify-content-md-end mb-2">
            <div class="col-3">
                <button id="create-new-menu" class="btn btn-success" type="button"><i class="fas fa-plus"></i> Create New
                    Menu</button>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4>List Of Menu</h4>
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
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="menu-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    <i class="fas fa-th"></i>
                                </th>
                                <th>#</th>
                                <th>Name</th>
                                <th>Parent</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allMenus as $menu)
                                <tr data-menu="{{ json_encode($menu) }}">
                                    <td>
                                        <div class="sort-handler">
                                            <i class="fas fa-th"></i>
                                        </div>
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Str::headline($menu->name) }}</td>
                                    <td>
                                        @if ($menu->parent == 0)
                                            <div class="badge badge-success mb-2">True</div>
                                            <div class="list-group">
                                                @foreach ($menu->child as $child)
                                                    <a href="{{ route($child->link) }}" target="_blank"
                                                        class="list-group-item list-group-item-action ">
                                                        {{ $child->name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="badge badge-warning">False</div>
                                        @endif
                                    </td>
                                    <td>{{ $menu->created_at }}</td>
                                    <td>
                                        @if ($menu->access_to == 'All')
                                            <div class="badge badge-success">Mentor</div>
                                            <div class="badge badge-success">Student</div>
                                        @elseif ($menu->access_to == 'M')
                                            <div class="badge badge-success">Mentor</div>
                                            <div class="badge badge-danger">Student</div>
                                        @elseif ($menu->access_to == 'S')
                                            <div class="badge badge-danger">Mentor</div>
                                            <div class="badge badge-success">Student</div>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning edit my-1"
                                            data-id="{{ $menu->id }}"><i class="fas fa-pen"></i>
                                            Edit</button>
                                        <button type="button" class="btn btn-danger delete my-1"
                                            data-id="{{ $menu->id }}"><i class="fas fa-trash"></i>
                                            Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-right">
                <nav class="d-block d-sm-inline-block">
                    <ul class="pagination mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1 <span
                                    class="sr-only">(current)</span></a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
@section('modals')
    <div class="modal fade" id="modal-create-menu" tabindex="-1" role="dialog" data-keyboard='false'
        data-backdrop="static" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Create New Application Menu</h5>
                </div>
                <div class="modal-body">
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
    <div class="modal fade" id="modal-edit-menu" tabindex="-1" role="dialog" data-keyboard='false'
        data-backdrop="static" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Application Menu</h5>
                </div>
                <div class="modal-body">
                    <form id="form-edit-menu">
                        <div class="alert alert-danger d-none">
                            <div class="alert-title">We Found Some Error</div>
                            <div class="alert-body">
                            </div>
                        </div>
                        <input type="hidden" name="id">
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
                            <label>Parent</label>
                            <select class="form-control" name="parent">
                            </select>
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
                    <button id="update-menu" type="button" class="btn btn-warning"><i class="fas fa-pen"></i> Update
                        Menu</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/page/bootstrap-modal.js') }}"></script>
    <script src="{{ asset('modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('modules/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#menu-table tbody").sortable({
                handle: '.sort-handler',
                update: function(event, ui) {
                    let data = [];
                    [...$("#menu-table tbody").find('tr')].forEach(element => {
                        data.push($(element).data('menu'))
                    });
                    $.ajax({
                        type: "POST",
                        url: `{{ route('master.menus.sort') }}`,
                        data: {
                            _token: `{{ csrf_token() }}`,
                            menus: data
                        },
                        dataType: "json",
                        success: function(response) {
                            swal(response.message, {
                                icon: 'success',
                            });
                            setTimeout(() => {
                                swal.close()
                                location.reload()
                            }, 1500);
                        }
                    });
                },
            });
            $('#create-new-menu').click(function() {
                $('#modal-create-menu').modal('show');
            });
            $('.edit').click(function() {
                let id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: `{{ route('master.menus.all') }}`,
                    dataType: "json",
                    success: function(response) {
                        let data_parent = response.record;
                        let html = `<option value=0>not filled in yet</option>`;
                        response.record.forEach(element => {
                            if (id != element.id) {
                                html +=
                                    `<option value="${element.id}">${element.name}</option>`;
                            }
                        });
                        $('#form-edit-menu').find('select[name=parent]').html(html)
                        $.ajax({
                            type: "GET",
                            url: `{{ url()->current() }}/show/${id}`,
                            dataType: "json",
                            beforeSend: function() {
                                swal('Loading');
                            },
                            success: function(response) {
                                $('#modal-edit-menu').modal('show');
                                $('#form-edit-menu').find('input[name=id]').val(
                                    response.record.id);
                                $('#form-edit-menu').find('input[name=name]').val(
                                    response.record.name);
                                $('#form-edit-menu').find('input[name=icon]').val(
                                    response.record.icon);
                                $('#form-edit-menu').find('input[name=link]').val(
                                    response.record.link);
                                $('#form-edit-menu').find('select[name=position]')
                                    .val(response.record.position)
                                    .trigger('change');
                                $('#form-edit-menu').find('select[name=parent]')
                                    .val(response.record.parent)
                                    .trigger('change');
                                if (response.record.access_to == "All") {
                                    $('#form-edit-menu')
                                        .find('select[name=access_to]')
                                        .find('option').attr('selected', true)
                                } else {
                                    $('#form-edit-menu')
                                        .find('select[name=access_to]')
                                        .val(response.record.access_to)
                                        .trigger('change');
                                }
                                swal.close();
                            }
                        });
                    }
                });
            });
            $(".delete").click(function() {
                let id = $(this).data('id');
                swal({
                        title: 'Are you sure?',
                        text: 'Once deleted, you will not be able to recover this menu!',
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: "DELETE",
                                url: `{{ url()->current() }}/delete/${id}`,
                                dataType: "json",
                                data: {
                                    _token: `{{ csrf_token() }}`
                                },
                                success: function(response) {
                                    swal('Poof! Your menu has been deleted!', {
                                        icon: 'success',
                                    });
                                    setTimeout(() => {
                                        swal.close()
                                        location.reload()
                                    }, 1500);
                                },
                                error: function(error) {
                                    swal(error.responseJSON.message, {
                                        icon: 'error'
                                    });
                                }
                            });
                        } else {
                            swal('Your menu is safe!');
                        }
                    });
            });
            $('#modal-create-menu').on('hidden.bs.modal', function() {
                $('.alert-danger').addClass('d-none');
                $(".alert-body").html(``);
                $('input[name=name]').val('');
                $('input[name=icon]').val('');
                $('input[name=link]').val('');
                $('select[name=position]').val('S').trigger('change');
                $('select[name=parent]').val('0').trigger('change');
                $('select[name=access_to]').val('M').trigger('change');
            })
            $('#save-menu').click(function() {
                $('.alert-danger').addClass('d-none');
                $(".alert-body").html(``)
                let data = {
                    _token: `{{ csrf_token() }}`,
                    name: $('#form-menu').find('input[name=name]').val(),
                    icon: $('#form-menu').find('input[name=icon]').val(),
                    link: $('#form-menu').find('input[name=link]').val(),
                    position: $('#form-menu').find('select[name=position]').val(),
                    access_to: $('#form-menu').find('select[name=access_to]').val(),
                }
                $.ajax({
                    type: "POST",
                    url: `{{ route('master.menus.store') }}`,
                    data: data,
                    dataType: "json",
                    beforeSend: function() {
                        swal('Loading');
                    },
                    success: function(response) {
                        swal('Good Job', response.message, 'success');
                        $('#modal-create-menu').modal('hide');
                        setTimeout(() => {
                            swal.close()
                            location.reload()
                        }, 1500);
                    },
                    error: function(error) {
                        if (error.responseJSON.errors != undefined) {
                            let html = ``;
                            if (error.responseJSON.errors.name != undefined) {
                                error.responseJSON.errors.name.forEach(element => {
                                    html +=
                                        `<div class="list-error">${element}</div>`;
                                });
                            }
                            if (error.responseJSON.errors.icon != undefined) {
                                error.responseJSON.errors.icon.forEach(element => {
                                    html +=
                                        `<div class="list-error">${element}</div>`;
                                });
                            }
                            if (error.responseJSON.errors.link != undefined) {
                                error.responseJSON.errors.link.forEach(element => {
                                    html +=
                                        `<div class="list-error">${element}</div>`;
                                });
                            }
                            if (error.responseJSON.errors.access_to != undefined) {
                                error.responseJSON.errors.access_to.forEach(element => {
                                    html +=
                                        `<div class="list-error">${element}</div>`;
                                });
                            }
                            $('.alert-danger').removeClass('d-none')
                            $(".alert-body").html(html)
                        }
                    }
                });
            });
            $('#update-menu').click(function() {
                $('.alert-danger').addClass('d-none');
                $(".alert-body").html(``)
                let data = {
                    _token: `{{ csrf_token() }}`,
                    id: $('#form-edit-menu').find('input[name=id]').val(),
                    name: $('#form-edit-menu').find('input[name=name]').val(),
                    icon: $('#form-edit-menu').find('input[name=icon]').val(),
                    link: $('#form-edit-menu').find('input[name=link]').val(),
                    parent: $('#form-edit-menu').find('select[name=parent]').val(),
                    position: $('#form-edit-menu').find('select[name=position]').val(),
                    access_to: $('#form-edit-menu').find('select[name=access_to]').val(),
                }
                $.ajax({
                    type: "PUT",
                    url: `{{ url()->current() }}/update/${data.id}`,
                    data: data,
                    dataType: "json",
                    beforeSend: function() {
                        swal('Loading');
                    },
                    success: function(response) {
                        swal('Good Job', response.message, 'success');
                        $('#modal-edit-menu').modal('hide');
                        setTimeout(() => {
                            swal.close()
                            location.reload()
                        }, 1500);
                    },
                    error: function(error) {
                        if (error.responseJSON.errors != undefined) {
                            let html = ``;
                            if (error.responseJSON.errors.name != undefined) {
                                error.responseJSON.errors.name.forEach(element => {
                                    html +=
                                        `<div class="list-error">${element}</div>`;
                                });
                            }
                            if (error.responseJSON.errors.icon != undefined) {
                                error.responseJSON.errors.icon.forEach(element => {
                                    html +=
                                        `<div class="list-error">${element}</div>`;
                                });
                            }
                            if (error.responseJSON.errors.link != undefined) {
                                error.responseJSON.errors.link.forEach(element => {
                                    html +=
                                        `<div class="list-error">${element}</div>`;
                                });
                            }
                            if (error.responseJSON.errors.access_to != undefined) {
                                error.responseJSON.errors.access_to.forEach(element => {
                                    html +=
                                        `<div class="list-error">${element}</div>`;
                                });
                            }
                            $('.alert-danger').removeClass('d-none')
                            $(".alert-body").html(html)
                        }
                    }
                });
            });
        });
    </script>
@endsection
