@extends('layout')
@section('titlepage','Instinct - Instinct Pharmacy System')
@section('title','Welcome')

@section('content')

<style>
    .img-fluid {
        max-width: 100%;
        height: auto;
    }

    .rounded-circle {
        border-radius: 50% !important;
    }

    .rounded {
        border-radius: .25rem !important;
    }

    .shadow-sm {
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
    }

    blockquote {
        background: #f8f9fa;
        padding: 15px;
        border-left: 5px solid #007bff;
    }

    .blockquote-footer {
        color: #6c757d;
    }
    </style>

    <div class="container my-5">
        <div class="text-center mb-5">
            <h2>About Us</h2>
            <p>Discover the story behind our fashion store</p>
        </div>

        <!-- Introduction Section -->
        <div class="row mb-5">
            <div class="col-md-6">
                <img src="{{ asset('img/a1.jpg') }}" alt="Fashion Store" class="img-fluid rounded shadow-sm">
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <div>
                    <h3>Our Mission</h3>
                    <p>We aim to provide the latest fashion trends at affordable prices. Our collection is curated with the utmost care to ensure the best quality and style for our customers.</p>
                    <p>Join us on our journey to make fashion accessible and enjoyable for everyone.</p>
                </div>
            </div>
        </div>

        <!-- Our Team Section -->
        <div class="text-center mb-5">
            <h3>Meet Our Team</h3>
        </div>
        <div class="row text-center">
            <div class="col-md-4">
                <img src="{{ asset('img/bs1.jpg') }}" alt="Team Member 1" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                <h5>Jane Doe</h5>
                <p>Master Doctor</p>
            </div>
            <div class="col-md-4">
                <img src="{{ asset('img/bs2.jpg') }}" alt="Team Member 2" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                <h5>John Smith</h5>
                <p>Senior Doctor</p>
            </div>
            <div class="col-md-4">
                <img src="{{ asset('img/bs3.jpg') }}" alt="Team Member 3" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                <h5>Emily Johnson</h5>
                <p>CEO</p>
            </div>
        </div>

        <!-- Product Showcase Section -->
        <div class="text-center mb-5">
            <h3>Our Products</h3>
        </div>
        <div class="row mb-5">
            <div class="col-md-4 mb-3">
                <img src="{{ asset('img/P25474_1.jpg') }}" alt="Product 1" class="img-fluid rounded shadow-sm">
                <h6 class="mt-2">Product 1</h6>
            </div>
            <div class="col-md-4 mb-3">
                <img src="{{ asset('img/P25174_1.jpg') }}" alt="Product 2" class="img-fluid rounded shadow-sm">
                <h6 class="mt-2">Product 2</h6>
            </div>
            <div class="col-md-4 mb-3">
                <img src="{{ asset('img/P02182_1.jpg') }}" alt="Product 3" class="img-fluid rounded shadow-sm">
                <h6 class="mt-2">Product 3</h6>
            </div>
        </div>

        <!-- Customer Reviews Section -->
        <div class="text-center mb-5">
            <h3>What Our Customers Say</h3>
        </div>
        <div class="row text-center">
            <div class="col-md-4">
                <blockquote class="blockquote">
                    <p class="mb-0">"Amazing quality and great customer service!"</p>
                    <footer class="blockquote-footer">Customer 1</footer>
                </blockquote>
            </div>
            <div class="col-md-4">
                <blockquote class="blockquote">
                    <p class="mb-0">"The best fashion store I've ever shopped at."</p>
                    <footer class="blockquote-footer">Customer 2</footer>
                </blockquote>
            </div>
            <div class="col-md-4">
                <blockquote class="blockquote">
                    <p class="mb-0">"Highly recommend for anyone looking for trendy clothes."</p>
                    <footer class="blockquote-footer">Customer 3</footer>
                </blockquote>
            </div>
        </div>
    </div>

@endsection
