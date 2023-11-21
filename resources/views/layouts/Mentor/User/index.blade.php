@extends('main')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>List All Student</h4>
        </div>
        <div class="card-body">
            <div class="row mb-1">
                <div class="col-3"><span>Show</span>
                    <select id="student-show">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span>entries</span>
                </div>
                <div class="col-9 text-right">
                    <span>Search:</span>
                    <input type="text" id="student-search">
                </div>
            </div>
            <table id="student-table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Number</th>
                        <th>Name & Username</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="card-footer text-right">
            <nav class="d-inline-block">
                <ul id="student-pagination" class="pagination mb-0">
                </ul>
            </nav>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function creatingTable(params = {
            datas: chunkResolver(window.students),
            element: 'table > tbody',
            indexStudent: 0,
            rowsCount: parseInt($('#student-show').val()),
            searchkey: $('#student-search').val()
        }) {
            if (params.searchkey != '') {
                params.datas = params.datas.flat().filter((data, index) => {
                    return data.first_name.split(params.searchkey).length > 1;
                });
            }
            params.datas = chunkArray((params.searchkey == '') ? params.datas.flat() : params.datas, params.rowsCount);

            let html = '';
            if (params.datas.length == 0) {
                $(params.element).html(html);
                return
            }
            params.datas[params.indexStudent].forEach((element, index) => {
                html += `<tr>
                            <td>${(params.rowsCount * params.indexStudent+1)+index}</td>
                            <td>${element.first_name} ${element.last_name} & ${element.username}</td>
                            <td>
                                <button class="btn btn-warning" data-id="${element.id}"><i class="fas fa-eye"></i>
                                    Show profile</button>
                            </td>
                        </tr>`;
            });
            $(params.element).html(html);
        }

        function creatingPagination(params = {
            datas: chunkResolver(window.students),
            element: '.pagination',
            indexStudent: 0,
            rowsCount: parseInt($('#student-show').val()),
            searchkey: $('#student-search').val()
        }) {
            creatingTable({
                datas: params.datas,
                element: 'table > tbody',
                indexStudent: params.indexStudent,
                rowsCount: params.rowsCount,
                searchkey: params.searchkey
            });
            let number = ``;
            if (params.searchkey != '') {
                params.datas = params.datas.flat().filter((data, index) => {
                    return data.first_name.split(params.searchkey).length > 1;
                });
            }
            params.datas = chunkArray((params.searchkey == '') ? params.datas.flat() : params.datas, params.rowsCount);
            if (params.datas.length > 0) {
                params.datas.forEach((element, index) => {
                    if (index == params.indexStudent || index == (params.indexStudent - 1) || index == (params
                            .indexStudent + 1)) {
                        number +=
                            `<li class="page-item ${params.indexStudent == index ? 'active' : ''}"><a class="page-link" onclick="creatingPagination({datas: chunkResolver(window.students), element: '.pagination', indexStudent: ${index}, rowsCount: parseInt($('#student-show').val()), searchkey: $('#student-search').val()})">${index+1}</a></li>`
                    }
                });
            }
            let html = `<li class="page-item ${params.indexStudent == 0 ? 'disabled' : ''}">
                            <a class="page-link" onclick="creatingPagination({datas: chunkResolver(window.students), element: '.pagination', indexStudent: ${params.indexStudent-1},rowsCount: parseInt($('#student-show').val()),searchkey: $('#student-search').val()})"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        ${number}
                        <li class="page-item ${(params.datas.length > 0 ? params.datas.length-1 : params.datas.length) == params.indexStudent ? 'disabled' : ''}">
                            <a class="page-link" onclick="creatingPagination({datas: chunkResolver(window.students), element: '.pagination', indexStudent: ${params.indexStudent+1},rowsCount: parseInt($('#student-show').val()),searchkey: $('#student-search').val()})"><i class="fas fa-chevron-right"></i></a>
                        </li>`;
            $(params.element).html(html);
        }

        function ready() {
            $(function() {
                creatingPagination();
                $('#student-show').change(function() {
                    creatingPagination();
                });
                $('#student-search').on('keyup', function() {
                    creatingPagination()
                });
            });
        }
        $.ajax({
            type: "get",
            url: "{{ route('database.user.all') }}",
            dataType: "json",
            success: function(response) {
                window.students = response.data;
                ready();
            },
            error: function(error) {
                window.students = error.responseJSON.data;
                ready();
            }
        });
    </script>
@endsection
