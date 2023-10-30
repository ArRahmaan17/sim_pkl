@extends('main')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ session('auth.role') == 'M' ? 'Student Cluster' : 'Your Cluster' }}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col border text-center mx-1">Dont Have Cluster</div>
                @foreach ($clusters as $cluster)
                    <div class="col border text-center mx-1">{{ $cluster->name }}</div>
                @endforeach
            </div>
            <div class="row">
                <div class="col row cluster shadow p-2 mx-1" id="cluster-null">
                    @foreach ($users as $user)
                        @if ($user->role == 'S' && $user->cluster_id == null)
                            <div class="col-12 rounded shadow mt-1" data-user="{{ json_encode($user) }}">
                                {{ $user->first_name . ' ' . $user->last_name }} / {{ $user->username }}
                            </div>
                        @endif
                    @endforeach
                </div>
                @foreach ($clusters as $cluster)
                    <div class="col row cluster shadow p-2 mx-1" id="cluster-{{ $cluster->id }}">
                        @foreach ($users as $user)
                            @if ($user->role == 'S' && $user->cluster_id == $cluster->id)
                                <div class="col-12 rounded shadow mt-1" data-user="{{ json_encode($user) }}">
                                    {{ $user->first_name . ' ' . $user->last_name }} / {{ $user->username }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.js'></script>
    <script src="{{ asset('modules/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $(function() {
            let container = $(document).find('.cluster').map((index, element) => {
                return $(element)[0]
            });
            let test = dragula([...container])
                .on('drag', function(el) {
                    el.className = el.className.replace('ex-moved', '');
                }).on('drop', function(el) {
                    el.className += ' ex-moved';
                    $.ajax({
                        type: "POST",
                        url: `{{ route('user.group.store') }}`,
                        data: $(el).data('user'),
                        dataType: "JSON",
                        success: function(response) {
                            swal(response.message, {
                                'icon': 'success'
                            })
                        },
                        error: function(error) {
                            swal(error.responseJSON.message, {
                                'icon': 'failed'
                            })
                        }
                    });
                }).on('over', function(el, container) {
                    container.className += ' ex-over';
                    let data = $(el).data('user');
                    data.cluster_id = $(container).attr('id').split('cluster-').join('');
                    data._token = `{{ csrf_token() }}`;
                    $(el).data('user', data);
                }).on('out', function(el, container) {
                    container.className = container.className.replace('ex-over', '');
                });
        });
    </script>
@endsection
