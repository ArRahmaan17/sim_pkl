@extends('main')
@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-stats">
                    <div class="card-stats-title">Attendance Statistics -
                        <div class="dropdown d-inline">
                            <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#"
                                id="attendance-month">{{ $month }}</a>
                            <ul class="dropdown-menu dropdown-menu-sm">
                                <li class="dropdown-title">Select Month</li>
                                <li><a href="{{ route('home') }}?month=1"
                                        class="dropdown-item {{ $month == 'January' ? 'active' : '' }}">January</a></li>
                                <li><a href="{{ route('home') }}?month=2"
                                        class="dropdown-item {{ $month == 'February' ? 'active' : '' }}">February</a>
                                </li>
                                <li><a href="{{ route('home') }}?month=3"
                                        class="dropdown-item {{ $month == 'March' ? 'active' : '' }}">March</a></li>
                                <li><a href="{{ route('home') }}?month=4"
                                        class="dropdown-item {{ $month == 'April' ? 'active' : '' }}">April</a></li>
                                <li><a href="{{ route('home') }}?month=5"
                                        class="dropdown-item {{ $month == 'May' ? 'active' : '' }}">May</a>
                                </li>
                                <li><a href="{{ route('home') }}?month=6"
                                        class="dropdown-item {{ $month == 'June' ? 'active' : '' }}">June</a>
                                </li>
                                <li><a href="{{ route('home') }}?month=7"
                                        class="dropdown-item {{ $month == 'July' ? 'active' : '' }}">July</a>
                                </li>
                                <li><a href="{{ route('home') }}?month=8"
                                        class="dropdown-item {{ $month == 'August' ? 'active' : '' }}">August</a></li>
                                <li><a href="{{ route('home') }}?month=9"
                                        class="dropdown-item {{ $month == 'September' ? 'active' : '' }}">September</a>
                                </li>
                                <li><a href="{{ route('home') }}?month=10"
                                        class="dropdown-item {{ $month == 'October' ? 'active' : '' }}">October</a>
                                </li>
                                <li><a href="{{ route('home') }}?month=11"
                                        class="dropdown-item {{ $month == 'November' ? 'active' : '' }}">November</a>
                                </li>
                                <li><a href="{{ route('home') }}?month=11"
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
                    <a href="{{ route('user.attendance.all') }}">
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
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-chart">
                    <canvas id="balance-chart" height="80"></canvas>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Balance</h4>
                    </div>
                    <div class="card-body">
                        $187,13
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-chart">
                    <canvas id="sales-chart" height="80"></canvas>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Sales</h4>
                    </div>
                    <div class="card-body">
                        4,732
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
