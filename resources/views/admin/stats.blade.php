@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">📊 Statistik Event</h4>
    <canvas id="eventChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const events = @json($events);

    const labels = events.map(e => e.nama);
    const dataHadir = events.map(e => e.hadir);
    const dataTidak = events.map(e => e.tidak_hadir);
    const dataKuota = events.map(e => e.kuota);

    const data = {
        labels: labels,
        datasets: [{
                label: 'Hadir',
                data: dataHadir,
                backgroundColor: 'green'
            },
            {
                label: 'Tidak Hadir',
                data: dataTidak,
                backgroundColor: 'red'
            },
            {
                label: 'Kuota',
                data: dataKuota,
                backgroundColor: 'blue'
            }
        ]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Statistik Kehadiran Event'
                }
            }
        }
    };

    new Chart(document.getElementById('eventChart'), config);
</script>
@endsection