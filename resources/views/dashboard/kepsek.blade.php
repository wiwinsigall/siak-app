@extends('layouts.mantis')

@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header text-dark d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><strong>📊 Dashboard Akademik</strong></h4>
        </div>
        <div class="card-body">

            {{-- Info Cards --}}
            <div class="row text-center mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm h-100" style="border: 2px solid #60a5fa;">
                        <div class="card-body">
                            <h5 class="fw-bold">{{ $jumlahGuru }}</h5>
                            <p class="mb-0">👨‍🏫 Guru</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm h-100" style="border: 2px solid #60a5fa;">
                        <div class="card-body">
                            <h5 class="fw-bold">{{ $jumlahSiswa }}</h5>
                            <p class="mb-0">🎓 Total Siswa</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm h-100" style="border: 2px solid #60a5fa;">
                        <div class="card-body">
                            <h5 class="fw-bold">{{ $jumlahLaki }}</h5>
                            <p class="mb-0">👦 Siswa Laki-laki</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm h-100" style="border: 2px solid #60a5fa;">
                        <div class="card-body">
                            <h5 class="fw-bold">{{ $jumlahPerempuan }}</h5>
                            <p class="mb-0">👧 Siswa Perempuan</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts --}}
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Perbandingan Jumlah Siswa Laki-laki dan Perempuan</h6>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <canvas id="genderChart" style="max-height: 300px;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">Jumlah Siswa per Jurusan</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="jurusanChart" style="max-height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Pie Chart: Perbandingan Gender
    const genderData = {
        labels: @json(['Laki-laki', 'Perempuan']),
        datasets: [{
            data: @json([$jumlahLaki, $jumlahPerempuan]),
            backgroundColor: ['#4680ff', '#f95f53'], // Mantis: primary, danger
            borderColor: '#fff',
            borderWidth: 2
        }]
    };

    new Chart(document.getElementById('genderChart'), {
        type: 'pie',
        data: genderData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        color: '#333'
                    }
                }
            }
        }
    });

    // Bar Chart: Jumlah Siswa per Jurusan
    const jurusanData = @json($siswaPerJurusan);
    const jurusanLabels = jurusanData.map(item => item.jurusan);
    const jurusanCounts = jurusanData.map(item => item.total);

    new Chart(document.getElementById('jurusanChart'), {
        type: 'bar',
        data: {
            labels: jurusanLabels,
            datasets: [{
                label: 'Jumlah Siswa',
                data: jurusanCounts,
                backgroundColor: '#2ca87f', // Mantis success
                borderColor: '#1e7e63',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#333'
                    },
                    grid: {
                        color: '#e0e0e0'
                    }
                },
                x: {
                    ticks: {
                        color: '#333'
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>

@endsection
