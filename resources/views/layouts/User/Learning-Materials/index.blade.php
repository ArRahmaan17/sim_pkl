@extends('main')
@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Name</td>
                        <td>Filename</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($learning_materials as $material)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $material->name }}</td>
                            <td><a
                                    href="{{ route('user.learning-materials.download', $material->id) }}">{{ $material->filename }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
