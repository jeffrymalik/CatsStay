@extends('layout.main')

@section('title', 'About-Us - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{asset('css/aboutus.css')}}">
@endsection

@section('content')
    <!-- Main Content -->
    <div class="container">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-content">
                <div class="breadcrumb">
                    <a href="#">Home</a> / <span>About</span>
                </div>
                <h1 class="hero-title">Your Cat's Second Home, Crafted with Care</h1>
                <p class="hero-description">
                    At Cats Stay, we provide a safe, comfortable, and homey environment for your cat. Our mission is to make every day special for your beloved pet while you're away.
                </p>
            </div>
            <div class="hero-image">
                <img src="{{asset('images/download.jpg')}}" alt="Cat on pillow">
            </div>
        </section>

        <!-- Vision Section -->
        <section class="vision-section">
            <div class="vision-image">
                <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=500&h=350&fit=crop" alt="Cat lying down">
            </div>
            <div class="vision-content">
                <h2 class="section-title">Our Vision</h2>
                <p class="section-description">
                    To make Cats Stay an e-commerce platform that connects cat owners with a variety of boarding service providers.
                </p>
            </div>
        </section>

        <!-- Mission Section -->
        <section class="mission-section">
            <div class="mission-content">
                <h2 class="section-title">Our Mission</h2>
                <ol class="mission-list">
                    <li>Provide a platform for cat owners to find trusted cat boarding services.</li>
                    <li>Create a safe and reliable ecosystem for service providers.</li>
                    <li>Facilitate transparent, practical, and integrated transactions through an online payment system.</li>
                    <li>Provide name and rating features to improve service quality and build trust.</li>
                </ol>
            </div>
            <div class="mission-image">
                <img src="https://images.unsplash.com/photo-1518791841217-8f162f1e1131?w=500&h=350&fit=crop" alt="Cat with food">
            </div>
        </section>
    </div>
@endsection
