@extends('layouts.app')  <!-- Menggunakan template dari app.blade.php -->

@section('container')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Galeri Produk</h1>
    </div>

    <!-- Button Filter -->
    <div class="row">
        <div class="col-12 text-center my-3">
            <button class="btn btn-primary filter-btn" data-category="all">Show All</button>
            <button class="btn btn-secondary filter-btn" data-category="1">Category 1</button>
            <button class="btn btn-secondary filter-btn" data-category="2">Category 2</button>
        </div>
    </div>

    <!-- Carousel Section -->
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('upload/p_headline_60-kata-kata-kamado-tanjiro-di-anime-ki-26bb2a.jpg') }}" class="d-block w-100" alt="foto-tanjiro-demon-slayer">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('upload/foto-tanjiro-demon-slayer.jpg') }}" class="d-block w-100" alt="tanjiro">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('upload/kamadotanjirosdrftgkamadotanjiro1660x400.jpg') }}" class="d-block w-100" alt="kamado">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Gallery Section -->
    <h2 class="mt-3 mb-2 m-sm-2">Gallery</h2>
    <div class="d-flex flex-wrap">
        <img src="https://divedigital.id/wp-content/uploads/2022/06/foto-tanjiro-demon-slayer.jpg" class="m-2 img-fluid category-1" alt="..." style="height: 200px;" data-category="1">
        <img src="https://divedigital.id/wp-content/uploads/2022/06/foto-tanjiro-demon-slayer.jpg" class="m-2 img-fluid category-2" alt="..." style="height: 200px;" data-category="2">
        <img src="https://divedigital.id/wp-content/uploads/2022/06/foto-tanjiro-demon-slayer.jpg" class="m-2 img-fluid category-1" alt="..." style="height: 200px;" data-category="1">
        <img src="https://divedigital.id/wp-content/uploads/2022/06/foto-tanjiro-demon-slayer.jpg" class="m-2 img-fluid category-2" alt="..." style="height: 200px;" data-category="2">
        <img src="https://divedigital.id/wp-content/uploads/2022/06/foto-tanjiro-demon-slayer.jpg" class="m-2 img-fluid category-1" alt="..." style="height: 200px;" data-category="1">
    </div>
</div>
<!-- /.container-fluid -->

@endsection
