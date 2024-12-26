@extends('layouts.app')

@section('title', 'Dashboard')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
@endpush

@section('content')
<div class="py-4">

    <div class="container py-4">
        <div class="d-flex justify-content-between flex-wrap mb-4">
            <div>
                <h1 class="h4">Artikel Dashboard</h1>
                <p class="mb-0">Statistik artikel di aplikasi blog Anda</p>
            </div>
        </div>

        <div class="row gy-4 justify-content-center">
            <div class="col-12 col-sm-8 col-lg-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h2 class="h6 text-gray-400 text-center mb-0">Total Artikel</h2>
                        <h3 class="fw-extrabold text-center mb-0">{{ $totalArticles ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-8 col-lg-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h2 class="h6 text-gray-400 text-center mb-0">Artikel Pending</h2>
                        <h3 class="fw-extrabold text-center mb-0">{{ $pendingArticles ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-8 col-lg-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h2 class="h6 text-gray-400 text-center mb-0">Artikel Sukses</h2>
                        <h3 class="fw-extrabold text-center mb-0">{{ $totalSuccess ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4 mt-4 justify-content-center">
            <div class="col-12 col-xl-8">
                <div class="card border-0 shadow h-100">
                    <div class="card-header">
                        <h2 class="fs-5 fw-bold mb-0">Artikel</h2>
                    </div>
                    <div class="card-body">
                        <canvas id="artikelChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('artikelChart').getContext('2d');
        var transactionChart = new Chart(ctx, {
            type: 'line',  // Menggunakan jenis grafik garis
            data: {
                labels: ['Total', 'Pending', 'Success'],  // Label kategori pada sumbu X
                datasets: [
                    {
                        label: 'Articles',  // Label untuk garis pertama
                        data: [
                            {{ $totalArticles ?? 0 }},
                            {{ $pendingArticles ?? 0 }},
                            {{ $totalSuccess ?? 0 }},
                        ],
                        backgroundColor: 'rgba(54, 162, 235, 0.4)',  // Warna latar belakang area bawah garis pertama
                        borderColor: 'rgba(54, 162, 235, 1)',  // Warna garis pertama
                        borderWidth: 3,  // Ketebalan garis pertama
                        fill: true,  // Mengisi area bawah garis pertama
                        tension: 0.4,  // Kelengkungan garis pertama
                    }
                ]
            },
            options: {
                responsive: true,  // Membuat chart responsif
                scales: {
                    y: {
                        beginAtZero: true,  // Sumbu Y dimulai dari angka 0
                    }
                },
                plugins: {
                    tooltip: {
                        mode: 'index',  // Menampilkan tooltip untuk semua dataset pada titik yang sama
                        intersect: false  // Membuat tooltip muncul saat cursor melintasi grafik
                    }
                }
            }
        });
    });
</script>





    <style>
        .table-categories {
            margin: 0 auto;
            width: 75%; /* Adjusted width to be less wide */
            border: 1px solid #dee2e6;
            border-radius: 10px;
        }
    </style>
    <div class="row justify-content-center"> <!-- Centered the row -->
        <h2 class="my-4 text-center">Kategori dan Total Artikel</h2> <!-- Centered the heading -->
        <div class="col-12 col-md-10"> <!-- Adjusted column width -->
            <div class="card mx-auto" style="max-width: 800px;"> <!-- Centered and constrained card width -->
                <div class="card-body">
                    <div class="table-responsive table-categories">
                        <table class="table align-middle table-striped table-hover">
                            <thead class="table-light">
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">Kategori</th>
                                    <th class="min-w-125px">Total Artikel</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                                @if(isset($categories) && count($categories) > 0)
                                    @foreach($categories as $category)
                                        <tr>
                                            <td class="d-flex align-items-center">
                                                <i class="bi bi-folder-fill fs-5 text-primary me-3"></i>
                                                <span class="text-truncate">{{ $category->category->name }}</span>
                                            </td>
                                            <td class="text-center">{{ $category->total }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Tidak ada kategori yang tersedia</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- end Content --}}

@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-4.0.0-beta.2.js"></script>
    {{-- <script src="{{ asset('assets/backend/library/jquery/jquery-3.7.1.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <script src={{ asset('assets/backend/js/helper.js') }}></script>
    <script src={{ asset('assets/backend/js/article.js') }}></script>

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

    {!! JsValidator::formRequest('App\Http\Requests\ArticleRequest', '#formConfirm') !!}
@endpush
