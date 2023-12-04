@extends('main')
@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
@endsection
@section('content')
    <div id="map" style="height: 500px"></div>
@endsection
@section('script')
    <script>
        var map = L.map('map', {
            center: [-6.2297401, 106.7471169],
            zoom: 6,
            maxZoon: 17,
        });
        L.tileLayer('http://mt0.google.com/vt/lyrs=y&hl=en&x={x}&y={y}&z={z}&s=Ga', {
            // attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        let circle = L.circle([-7.5901996, 110.9505213], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 90
        }).addTo(map)
        let data = JSON.parse(`<?php echo $attendance; ?>`);
        data.forEach(element => {
            long = element.location.split(',')[0];
            lat = element.location.split(',')[1];
            let marker = L.marker([long, lat]).addTo(map);
            marker.on('click', function(e) {
                var popup = L.popup();
                popup.setLatLng(e.latlng).setContent(
                        `<div class="m-2">
                            <img class="rounded img-popup" src="data:image/jpeg;base64,${element.photo}">
                            <div class="mt-1">${element.user.first_name} ${element.user.last_name} Absent in ${element.time} status ${element.status}</div>
                        </div>`
                    )
                    .openOn(map);
                $('.img-popup').css('max-width', '100%');
            })
        });
    </script>
@endsection
