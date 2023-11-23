@extends('main')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Calendar</h4>
                </div>
                <div class="card-body">
                    <div class="fc-overflow">
                        <div id="myEvent"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"
        integrity="sha256-alsi6DkexWIdeVDEct5s7cnqsWgOqsh2ihuIZbU6H3I=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.9/index.global.min.js"
        integrity="sha256-iKVE5HEtCnA5SofeoQF7Egh6tlQCNoadKoY2lUNJjA4=" crossorigin="anonymous"></script>
    <script>
        $(function() {
            var data = JSON.parse(`<?php echo $attendance; ?>`);
            var todos = JSON.parse(`<?php echo $todos; ?>`);
            let modified_data = [];
            data.forEach(element => {
                modified_data.push({
                    start: element.created_at.split('.000000Z').join(''),
                    end: element.created_at.split('T')[0] + `T${element.time}`,
                    title: `Attendance ${element.status} ${element.user.first_name} ${element.user.last_name}`,
                    overlap: true,
                    display: 'block',
                    color: element.status == 'IN' ? '#95f702' : element.status == 'SICK' ?
                        '#f7de02' : element.status == 'ABSENT' ? '#f76402' : element.status ==
                        'OUT' ? '#f70206' : '',
                    textColor: element.status == 'IN' ? '#000' : element.status == 'SICK' ?
                        '#000' : element.status == 'ABSENT' ? '#FFF' : element.status ==
                        'OUT' ? '#FFF' : ''
                });
            });
            todos.forEach(element => {
                modified_data.push({
                    start: element.created_at.split('.000000Z').join(''),
                    end: element.created_at.split('T')[0] + `T${element.time}`,
                    title: element.description,
                    overlap: true,
                    display: 'block',
                    color: element.status == 'IN' ? '#95f702' : element.status == 'SICK' ?
                        '#f7de02' : element.status == 'ABSENT' ? '#f76402' : element.status ==
                        'OUT' ? '#f70206' : '',
                    textColor: element.status == 'IN' ? '#000' : element.status == 'SICK' ?
                        '#000' : element.status == 'ABSENT' ? '#FFF' : element.status ==
                        'OUT' ? '#FFF' : ''
                });
            })
            console.log(modified_data);
            var calendarEl = document.getElementById('myEvent');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                dayMaxEventRows: 5,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                initialDate: `{{ now('Asia/Jakarta') }}`,
                initialView: 'dayGridMonth',
                events: modified_data,
            });
            calendar.render();
        });
    </script>
@endsection
