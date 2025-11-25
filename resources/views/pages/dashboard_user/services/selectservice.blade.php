@extends('layout.main')

@section('title', 'Select Service - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{asset('css/select-service.css')}}">
@endsection

@section('content')
<div class="select-service-container">
    <div class="select-service-content">
        
        {{-- Header --}}
        <div class="select-service-header">
            <h1 class="select-service-title">What service do you need?</h1>
            <p class="select-service-subtitle">Choose a service to find trusted cat sitters who offer it</p>
        </div>

        {{-- Service Cards Grid --}}
        <div class="services-grid">
            @foreach($services as $service)
            <div class="service-card">
                
                {{-- Card Header --}}
                <div class="service-card-header">
                    <div class="service-icon">{{ $service['icon'] }}</div>
                    <h2 class="service-name">{{ $service['name'] }}</h2>
                    <div class="service-price-box">
                        <p class="service-price-note">{{ $service['price_note'] }}</p>
                        <p class="service-price-subtext">Each sitter sets their own rate</p>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="service-card-body">
                    <p class="service-description">{{ $service['description'] }}</p>

                    {{-- Features List --}}
                    <h3 class="service-features-title">What's Included:</h3>
                    <ul class="service-features-list">
                        @foreach($service['features'] as $feature)
                        <li class="service-feature-item">
                            <div class="service-feature-icon">
                                <svg viewBox="0 0 20 20" fill="#FFA726" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="service-feature-text">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>

                    {{-- Find Sitters Button --}}
                    <form action="{{ url('/select-service/' . $service['slug']) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-select-service">
                            Find Sitters for {{ $service['name'] }}
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Info Section --}}
        <div class="select-service-info">
            <div class="info-content">
                <div class="info-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="info-text-wrapper">
                    <h3 class="info-title">Want to browse all sitters first?</h3>
                    <p class="info-description">Not sure which service you need? Browse all available sitters, compare their profiles, read reviews, and see what services each one offers.</p>
                    <a href="{{ url('/find-sitter') }}" class="info-link">
                        <span>Browse All Sitters</span>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Back to Dashboard --}}
        <div class="back-to-dashboard">
            <a href="{{ url('/dashboard') }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back to Dashboard</span>
            </a>
        </div>

    </div>
</div>

@if(session('error'))
<script>
    alert('{{ session('error') }}');
</script>
@endif
@endsection