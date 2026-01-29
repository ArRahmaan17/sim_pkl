@extends('main')
@section('title')
    {{ __('menus.dashboard') }}
@endsection
@push('vendor-css')
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-statistic-2">
                <div class="card-stats">
                    <div class="card-stats-title">Attendance Statistics -
                        <div class="dropdown d-inline">
                            <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="attendance-month">{{ $month }}</a>
                            <ul class="dropdown-menu dropdown-menu-sm">
                                <li class="dropdown-title">Select Month</li>
                                <li><a href="{{ route('home.index') }}?month=1" class="dropdown-item {{ $month == 'January' ? 'active' : '' }}">January</a>
                                </li>
                                <li><a href="{{ route('home.index') }}?month=2" class="dropdown-item {{ $month == 'February' ? 'active' : '' }}">February</a>
                                </li>
                                <li><a href="{{ route('home.index') }}?month=3" class="dropdown-item {{ $month == 'March' ? 'active' : '' }}">March</a></li>
                                <li><a href="{{ route('home.index') }}?month=4" class="dropdown-item {{ $month == 'April' ? 'active' : '' }}">April</a></li>
                                <li><a href="{{ route('home.index') }}?month=5" class="dropdown-item {{ $month == 'May' ? 'active' : '' }}">May</a>
                                </li>
                                <li><a href="{{ route('home.index') }}?month=6" class="dropdown-item {{ $month == 'June' ? 'active' : '' }}">June</a>
                                </li>
                                <li><a href="{{ route('home.index') }}?month=7" class="dropdown-item {{ $month == 'July' ? 'active' : '' }}">July</a>
                                </li>
                                <li><a href="{{ route('home.index') }}?month=8" class="dropdown-item {{ $month == 'August' ? 'active' : '' }}">August</a>
                                </li>
                                <li><a href="{{ route('home.index') }}?month=9"
                                        class="dropdown-item {{ $month == 'September' ? 'active' : '' }}">September</a>
                                </li>
                                <li><a href="{{ route('home.index') }}?month=10" class="dropdown-item {{ $month == 'October' ? 'active' : '' }}">October</a>
                                </li>
                                <li><a href="{{ route('home.index') }}?month=11"
                                        class="dropdown-item {{ $month == 'November' ? 'active' : '' }}">November</a>
                                </li>
                                <li><a href="{{ route('home.index') }}?month=12"
                                        class="dropdown-item {{ $month == 'December' ? 'active' : '' }}">December</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-stats-items">
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">{{ $in }}</div>
                            <div class="card-stats-item-label">In</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">{{ $sick }}</div>
                            <div class="card-stats-item-label">Sick</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count">{{ $absent }}</div>
                            <div class="card-stats-item-label">Absent</div>
                        </div>
                    </div>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                    <a href="{{ route('user.attendance.calendar') }}">
                        <i class="fas fa-chart-line"></i>
                    </a>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Activity</h4>
                    </div>
                    <div class="card-body">
                        {{ $in + $sick + $absent }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
