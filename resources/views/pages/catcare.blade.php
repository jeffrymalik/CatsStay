@extends('layout.main')

@section('title', 'CatCare - Cats Stay')

@section('css')
<link rel="stylesheet" href="{{asset('css/catcare.css')}}">
@endsection

@section('content')
   <!-- Main Content -->
    <div class="container">
        <!-- Filter Section -->
        <div class="filter-section" id="filterSection">
            <div class="filter-row">
                <div class="filter-item">
                    <label>Lokasi</label>
                    <select>
                        <option>Jakarta Selatan</option>
                        <option>Jakarta Pusat</option>
                        <option>Jakarta Utara</option>
                        <option>Jakarta Barat</option>
                        <option>Jakarta Timur</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label>Dari</label>
                    <input type="text" placeholder="20 Okt" value="20 Okt">
                </div>
                <div class="filter-item">
                    <label>Sampai</label>
                    <input type="text" placeholder="24 Okt" value="24 Okt">
                </div>
                <button class="btn btn-find">Find a sitter</button>
            </div>
        </div>

        <!-- Detail Page -->
        <div class="detail-page" id="detailPage">
            <button class="back-btn" onclick="showCards()">← Back</button>
            
            <div class="profile-section">
                <div class="profile-left">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=400&fit=crop" alt="Profile" class="profile-image" id="detailProfileImage">
                </div>
                <div class="profile-right">
                    <h1 class="profile-name" id="detailName">Anggara</h1>
                    <div class="profile-info">
                        <div class="info-item">
                            <span class="info-icon">📝</span>
                            <span id="detailReviews">50 reviews complete</span>
                        </div>
                        <div class="info-item">
                            <span class="info-icon">💳</span>
                            <span>Rp.60.000/Days</span>
                        </div>
                        <div class="info-item">
                            <span class="info-icon">📅</span>
                            <span>Gabung dari October 15, 2020</span>
                        </div>
                        <div class="info-item">
                            <span class="stars">★★★★★</span>
                            <span>(50 Reviews)</span>
                        </div>
                        <div class="info-item">
                            <span class="location-tag">📍 Depok, Jawa Barat</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gallery -->
            <div class="gallery-section">
                <div class="gallery-grid">
                    <img src="https://images.unsplash.com/photo-1574158622682-e40e69881006?w=300&h=300&fit=crop" alt="Gallery 1" class="gallery-image">
                    <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=300&h=300&fit=crop" alt="Gallery 2" class="gallery-image">
                    <img src="https://images.unsplash.com/photo-1519052537078-e6302a4968d4?w=300&h=300&fit=crop" alt="Gallery 3" class="gallery-image">
                    <img src="https://images.unsplash.com/photo-1573865526739-10c1dd8f0f51?w=300&h=300&fit=crop" alt="Gallery 4" class="gallery-image">
                </div>
            </div>

            <!-- Reviews -->
            <div class="reviews-section">
                <div class="section-header">
                    <h2 class="section-title">50 Reviews</h2>
                    <button class="btn-review">Find review</button>
                </div>
                
                <div class="reviews-container">
                    <div class="review-item">
                        <div class="review-header">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=80&h=80&fit=crop" alt="Reviewer" class="review-avatar">
                            <div class="review-info">
                                <div class="reviewer-name">Nazar Rifa Anggara</div>
                                <div class="review-date">28 Oct</div>
                            </div>
                            <div class="review-stars">★★★★★</div>
                        </div>
                        <p class="review-text">Pelayanan Sangat Baik.</p>
                    </div>

                    <div class="review-item">
                        <div class="review-header">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=80&h=80&fit=crop" alt="Reviewer" class="review-avatar">
                            <div class="review-info">
                                <div class="reviewer-name">Nazar Rifa Anggara</div>
                                <div class="review-date">28 Oct</div>
                            </div>
                            <div class="review-stars">★★★★★</div>
                        </div>
                        <p class="review-text">Pelayanan Sangat Baik.</p>
                    </div>

                    <div class="review-item">
                        <div class="review-header">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=80&h=80&fit=crop" alt="Reviewer" class="review-avatar">
                            <div class="review-info">
                                <div class="reviewer-name">Rifa Ahmad</div>
                                <div class="review-date">27 Oct</div>
                            </div>
                            <div class="review-stars">★★★★★</div>
                        </div>
                        <p class="review-text">Sangat puas dengan pelayanan yang diberikan. Kucing saya dirawat dengan baik sekali!</p>
                    </div>

                    <div class="review-item">
                        <div class="review-header">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=80&h=80&fit=crop" alt="Reviewer" class="review-avatar">
                            <div class="review-info">
                                <div class="reviewer-name">Halim Santoso</div>
                                <div class="review-date">26 Oct</div>
                            </div>
                            <div class="review-stars">★★★★★</div>
                        </div>
                        <p class="review-text">Recommended! Cat sitter yang sangat profesional dan care terhadap hewan.</p>
                    </div>

                    <div class="review-item">
                        <div class="review-header">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=80&h=80&fit=crop" alt="Reviewer" class="review-avatar">
                            <div class="review-info">
                                <div class="reviewer-name">Budi Setiawan</div>
                                <div class="review-date">25 Oct</div>
                            </div>
                            <div class="review-stars">★★★★★</div>
                        </div>
                        <p class="review-text">Tempat yang nyaman dan bersih. Kucing saya kelihatan senang!</p>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="booking-section">
                <div class="booking-form">
                    <div class="form-group">
                        <label>Number of Cats</label>
                        <select>
                            <option>Number of Cats</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4+</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Days</label>
                        <select>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5+</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date Booking</label>
                        <input type="text" placeholder="20 Okt" value="20 Okt">
                    </div>
                    <div class="form-group">
                        <label>Additional Service</label>
                        <select>
                            <option>Grooming</option>
                            <option>Vaccination</option>
                            <option>Health Check</option>
                        </select>
                    </div>
                </div>
                <div class="booking-buttons">
                    <button class="btn-contact">Contact</button>
                    <button class="btn-booking">Booking</button>
                </div>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="cards-grid" id="cardsGrid">
            <!-- Card 1 -->
            <div class="card" onclick="showDetail('Anggara', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=400&fit=crop')">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=300&fit=crop" alt="Anggara" class="card-image">
                <div class="card-content">
                    <div class="card-header">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=50&h=50&fit=crop" alt="Avatar" class="avatar">
                        <span class="card-name">Anggara</span>
                    </div>
                    <p class="card-description">We Strive to provide a luxurious and personalized experience for your cat</p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="card" onclick="showDetail('Nazar', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop')">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=300&fit=crop" alt="Nazar" class="card-image">
                <div class="card-content">
                    <div class="card-header">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=50&h=50&fit=crop" alt="Avatar" class="avatar">
                        <span class="card-name">Nazar</span>
                    </div>
                    <p class="card-description">We Strive to provide a luxurious and personalized experience for your cat</p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="card" onclick="showDetail('Rifa', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=400&fit=crop')">
                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=300&fit=crop" alt="Rifa" class="card-image">
                <div class="card-content">
                    <div class="card-header">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=50&h=50&fit=crop" alt="Avatar" class="avatar">
                        <span class="card-name">Rifa</span>
                    </div>
                    <p class="card-description">We Strive to provide a luxurious and personalized experience for your cat</p>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="card" onclick="showDetail('Halim', 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=400&h=400&fit=crop')">
                <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=400&h=300&fit=crop" alt="Halim" class="card-image">
                <div class="card-content">
                    <div class="card-header">
                        <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=50&h=50&fit=crop" alt="Avatar" class="avatar">
                        <span class="card-name">Halim</span>
                    </div>
                    <p class="card-description">We Strive to provide a luxurious and personalized experience for your cat</p>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="card" onclick="showDetail('Anggara', 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=400&fit=crop')">
                <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=300&fit=crop" alt="Anggara" class="card-image">
                <div class="card-content">
                    <div class="card-header">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=50&h=50&fit=crop" alt="Avatar" class="avatar">
                        <span class="card-name">Anggara</span>
                    </div>
                    <p class="card-description">We Strive to provide a luxurious and personalized experience for your cat</p>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="card" onclick="showDetail('Nazar', 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=400&fit=crop')">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=300&fit=crop" alt="Nazar" class="card-image">
                <div class="card-content">
                    <div class="card-header">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=50&h=50&fit=crop" alt="Avatar" class="avatar">
                        <span class="card-name">Nazar</span>
                    </div>
                    <p class="card-description">We Strive to provide a luxurious and personalized experience for your cat</p>
                </div>
            </div>

            <!-- Card 7 -->
            <div class="card" onclick="showDetail('Rifa', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&h=400&fit=crop')">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&h=300&fit=crop" alt="Rifa" class="card-image">
                <div class="card-content">
                    <div class="card-header">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=50&h=50&fit=crop" alt="Avatar" class="avatar">
                        <span class="card-name">Rifa</span>
                    </div>
                    <p class="card-description">We Strive to provide a luxurious and personalized experience for your cat</p>
                </div>
            </div>

            <!-- Card 8 -->
            <div class="card" onclick="showDetail('Halim', 'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?w=400&h=400&fit=crop')">
                <img src="https://images.unsplash.com/photo-1519345182560-3f2917c472ef?w=400&h=300&fit=crop" alt="Halim" class="card-image">
                <div class="card-content">
                    <div class="card-header">
                        <img src="https://images.unsplash.com/photo-1519345182560-3f2917c472ef?w=50&h=50&fit=crop" alt="Avatar" class="avatar">
                        <span class="card-name">Halim</span>
                    </div>
                    <p class="card-description">We Strive to provide a luxurious and personalized experience for your cat</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="{{asset('js/catcare.js')}}"></script>
@endsection