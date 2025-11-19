@extends('layout.main')

@section('title', 'Home - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{asset('css/home.css')}}">
@endsection

@section('content')
<div class="hero-container">
    <div class="header-wrapper">
      <img class="paw-icon" src="images/Group1.svg" alt="">
        <h1 class="hero-title">
            <span class="title-line1">Welcome to <span class="highlight-orange">Cats</span> Stay</span>
        </h1>
        
      <img class="paw-icon" src="images/Group.svg" alt="">
    </div>
    
    <h2 class="hero-title title-line2">
        Your <span class="highlight-yellow">Cats</span> Second <span class="highlight-yellow">Home</span>!
    </h2>
    
    <p class="hero-subtitle">
        At Cats Stay, we make sure every cat feels safe, loved, and comfortable just like home.<br>
        The perfect place for your furry friend while you're away.
    </p>
    
    <div class="hero-buttons">
        <button class="btn btn-primary">Read More</button>
        <button class="btn btn-secondary">
            <div class="play-icon"></div>
            Watch Video
        </button>
    </div>
    
    <div class="cats-showcase">
        <div class="cat-card">
            <img src="https://images.unsplash.com/photo-1574158622682-e40e69881006?w=500&h=500&fit=crop" alt="Cat with blue background">
        </div>
        <div class="cat-card">
            <img src="https://images.unsplash.com/photo-1596854407944-bf87f6fdd49e?w=500&h=500&fit=crop" alt="Orange cat with yellow background">
        </div>
        <div class="cat-card">
            <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=500&h=500&fit=crop" alt="Tabby cat">
        </div>
    </div>
</div>

<!-- Service Section - Tambahkan setelah </div> penutup hero-container -->
<section class="service-section">
  <div class="service-container">
    <!-- Left Side - Title and Description -->
    <div class="service-left">
      <div class="paw-decoration">
        <img src="images/Group.svg" alt="paw" class="paw paw-1">
        <img src="images/Group.svg" alt="paw" class="paw paw-2">
        <img src="images/Group.svg" alt="paw" class="paw paw-3">
        <img src="images/Group.svg" alt="paw" class="paw paw-4">
      </div>

      <div class="service-content">
        <h3 class="service-subtitle">OUR SERVICES</h3>
        <h2 class="service-title">A Haven of Indulgence and Customized Pet Services</h2>
        <p class="service-description">We Strive to provide a lucrious and Personalized experience for your cat</p>
      </div>

      <div class="paw-decoration paw-bottom">
        <img src="images/Group.svg" alt="paw" class="paw paw-5">
        <img src="images/Group.svg" alt="paw" class="paw paw-6">
        <img src="images/Group.svg" alt="paw" class="paw paw-7">
        <img src="images/Group.svg" alt="paw" class="paw paw-8">
      </div>
    </div>

    <!-- Right Side - Service Cards -->
    <div class="service-right">
      <div class="service-card">
        <div class="service-icon">
          <img src="images/pet-house.svg" alt="Cat Boarding">
        </div>
        <h4 class="service-card-title">Cat Boarding</h4>
        <p class="service-card-description">We Strive to provide a lucrious and Personalized experience for your cat</p>
      </div>

      <div class="service-card">
        <div class="service-icon">
          <img src="images/Cat-Grooming.svg" alt="Cat Grooming">
        </div>
        <h4 class="service-card-title">Cat Grooming</h4>
        <p class="service-card-description">We Strive to provide a lucrious and Personalized experience for your cat</p>
      </div>

      <div class="service-card service-card-center">
        <div class="service-icon">
          <img src="images/Cat-sitter.png" alt="Cat Sitter">
        </div>
        <h4 class="service-card-title">Cat Sitter</h4>
        <p class="service-card-description">We Strive to provide a lucrious and Personalized experience for your cat</p>
      </div>
    </div>
  </div>
</section>

<!-- Our Sitter Section - Tambahkan setelah penutup </section> dari service-section -->
<section class="sitter-section">
  <div class="sitter-container">
    <h2 class="sitter-title">OUR SITTER</h2>
    
    <div class="sitter-grid">
      <!-- Sitter Card 1 -->
      <div class="sitter-card">
        <div class="sitter-image">
          <img src="https://images.unsplash.com/photo-1529257414772-1960b7bea4eb?w=500&h=400&fit=crop" alt="Anggara with cat">
        </div>
        <div class="sitter-info">
          <div class="sitter-profile">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop" alt="Anggara" class="sitter-avatar">
            <div class="sitter-details">
              <div class="sitter-name-rating">
                <h4 class="sitter-name">Anggara</h4>
                <span class="sitter-rating">4.5 ⭐</span>
              </div>
            </div>
          </div>
          <p class="sitter-description">We Strive to provide a lucrious and Personalized experience for your cat</p>
        </div>
      </div>

      <!-- Sitter Card 2 -->
      <div class="sitter-card">
        <div class="sitter-image">
          <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=500&h=400&fit=crop" alt="Nazar with cat">
        </div>
        <div class="sitter-info">
          <div class="sitter-profile">
            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop" alt="Nazar" class="sitter-avatar">
            <div class="sitter-details">
              <div class="sitter-name-rating">
                <h4 class="sitter-name">Nazar</h4>
                <span class="sitter-rating">5.0 ⭐</span>
              </div>
            </div>
          </div>
          <p class="sitter-description">We Strive to provide a lucrious and Personalized experience for your cat</p>
        </div>
      </div>

      <!-- Sitter Card 3 -->
      <div class="sitter-card">
        <div class="sitter-image">
          <img src="https://images.unsplash.com/photo-1573865526739-10c1de0ace9d?w=500&h=400&fit=crop" alt="Rifa with cat">
        </div>
        <div class="sitter-info">
          <div class="sitter-profile">
            <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=100&h=100&fit=crop" alt="Rifa" class="sitter-avatar">
            <div class="sitter-details">
              <div class="sitter-name-rating">
                <h4 class="sitter-name">Rifa</h4>
                <span class="sitter-rating">4.8 ⭐</span>
              </div>
            </div>
          </div>
          <p class="sitter-description">We Strive to provide a lucrious and Personalized experience for your cat</p>
        </div>
      </div>

      <!-- Sitter Card 4 -->
      <div class="sitter-card">
        <div class="sitter-image">
          <img src="https://images.unsplash.com/photo-1495360010541-f48722b34f7d?w=500&h=400&fit=crop" alt="Halim with cat">
        </div>
        <div class="sitter-info">
          <div class="sitter-profile">
            <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=100&h=100&fit=crop" alt="Halim" class="sitter-avatar">
            <div class="sitter-details">
              <div class="sitter-name-rating">
                <h4 class="sitter-name">Halim</h4>
                <span class="sitter-rating">4.9 ⭐</span>
              </div>
            </div>
          </div>
          <p class="sitter-description">We Strive to provide a lucrious and Personalized experience for your cat</p>
        </div>
      </div>
    </div>

    <!-- See All Button -->
    <div class="sitter-footer">
      <a href="#" class="btn-see-all">
        See All
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
    </div>
  </div>
</section>
@endsection