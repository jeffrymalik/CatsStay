@extends('layout.main')
@section('title', 'Dashboard - Cats Stay')
@section('css')
<link rel="stylesheet" href="{{asset('css/sitter/dashboard-sitter.css')}}">
@endsection

@section('content')
<!-- Dashboard Content -->
<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="welcome-text">
            <h1>Selamat Datang, Sarah! 👋</h1>
            <p>Kelola layanan pet sitting Anda dengan mudah</p>
        </div>
        <div class="welcome-date">
            <i class="fas fa-calendar"></i>
            <span id="current-date"></span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <!-- Total Orders -->
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-content">
                <h3>Total Orderan</h3>
                <p class="stat-number">47</p>
                <div class="stat-footer">
                    <span class="stat-label">Total keseluruhan</span>
                </div>
            </div>
        </div>

        <!-- Daily Earnings -->
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <h3>Pendapatan Harian</h3>
                <p class="stat-number">Rp 450.000</p>
                <div class="stat-footer">
                    <div class="earnings-selector">
                        <button class="earnings-btn active" data-period="today">Hari Ini</button>
                        <button class="earnings-btn" data-period="yesterday">Kemarin</button>
                        <button class="earnings-btn" data-period="month">Bulan Ini</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests -->
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-content">
                <h3>Request Masuk</h3>
                <p class="stat-number">3</p>
                <div class="stat-footer">
                    <span class="stat-badge pending">Menunggu respon</span>
                </div>
            </div>
        </div>

        <!-- Average Rating -->
        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-content">
                <h3>Rating Rata-rata</h3>
                <p class="stat-number">4.8</p>
                <div class="stat-footer">
                    <div class="rating-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span class="review-count">(24 reviews)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings Chart & Quick Actions -->
    <div class="chart-actions-grid">
        <!-- Earnings Chart -->
        <div class="chart-card">
            <div class="card-header">
                <h2>📈 Trend Pendapatan</h2>
                <div class="chart-controls">
                    <select id="chart-period" class="chart-select">
                        <option value="6">6 Bulan Terakhir</option>
                        <option value="12">12 Bulan Terakhir</option>
                        <option value="3">3 Bulan Terakhir</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <canvas id="earningsChart"></canvas>
            </div>
            <div class="chart-summary">
                <div class="summary-item">
                    <span class="summary-label">Total Pendapatan (6 Bulan)</span>
                    <span class="summary-value">Rp 12.450.000</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Rata-rata per Bulan</span>
                    <span class="summary-value">Rp 2.075.000</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions-card">
            <div class="card-header">
                <h2>⚡ Quick Actions</h2>
            </div>
            <div class="card-body">
                <div class="action-buttons">
                    <button class="action-btn schedule">
                        <div class="action-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="action-text">
                            <h4>View My Schedule</h4>
                            <p>Lihat jadwal booking</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <button class="action-btn services">
                        <div class="action-icon">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="action-text">
                            <h4>Edit Services</h4>
                            <p>Kelola layanan Anda</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <button class="action-btn profile">
                        <div class="action-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div class="action-text">
                            <h4>Update Profile</h4>
                            <p>Edit profil sitter</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <button class="action-btn earnings">
                        <div class="action-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="action-text">
                            <h4>View Earnings</h4>
                            <p>Lihat detail pendapatan</p>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications & Recent Requests -->
    <div class="notifications-requests-grid">
        <!-- Notifications/Alerts -->
        <div class="notifications-card">
            <div class="card-header">
                <h2>🔔 Notifikasi & Alerts</h2>
                <button class="mark-read-btn">Tandai semua dibaca</button>
            </div>
            <div class="card-body">
                <div class="notification-list">
                    <!-- New Request Alert -->
                    <div class="notification-item new">
                        <div class="notif-icon request">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <div class="notif-content">
                            <h4>Request Baru dari Michael Chen</h4>
                            <p>Cat Boarding - 3 hari (15-18 Des 2024)</p>
                            <span class="notif-time">5 menit yang lalu</span>
                        </div>
                        <button class="notif-action">Lihat</button>
                    </div>

                    <!-- New Request Alert -->
                    <div class="notification-item new">
                        <div class="notif-icon request">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <div class="notif-content">
                            <h4>Request Baru dari Lisa Anderson</h4>
                            <p>Daily Visit - 5 hari (20-25 Des 2024)</p>
                            <span class="notif-time">2 jam yang lalu</span>
                        </div>
                        <button class="notif-action">Lihat</button>
                    </div>

                    <!-- Upcoming Booking Alert -->
                    <div class="notification-item urgent">
                        <div class="notif-icon booking">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="notif-content">
                            <h4>Booking Dimulai Besok!</h4>
                            <p>Sarah Williams - Cat Sitting (1 Des 2024)</p>
                            <span class="notif-time">Besok, 09:00</span>
                        </div>
                        <button class="notif-action">Detail</button>
                    </div>

                    <!-- New Review Alert -->
                    <div class="notification-item">
                        <div class="notif-icon review">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="notif-content">
                            <h4>Review Baru - Rating 5⭐</h4>
                            <p>David Martinez memberikan review positif</p>
                            <span class="notif-time">1 hari yang lalu</span>
                        </div>
                        <button class="notif-action">Lihat</button>
                    </div>

                    <!-- Booking Starting Today -->
                    <div class="notification-item urgent">
                        <div class="notif-icon booking">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="notif-content">
                            <h4>Booking Dimulai Hari Ini!</h4>
                            <p>Emma Thompson - Daily Visit (30 Nov 2024)</p>
                            <span class="notif-time">Hari ini, 14:00</span>
                        </div>
                        <button class="notif-action">Detail</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Booking Requests -->
        <div class="recent-requests-card">
            <div class="card-header">
                <h2>📋 Request Terbaru</h2>
                <a href="#" class="view-all-link">Lihat Semua →</a>
            </div>
            <div class="card-body">
                <div class="request-list">
                    <!-- Request Item 1 -->
                    <div class="request-item pending">
                        <div class="request-header">
                            <img src="https://ui-avatars.com/api/?name=Michael+Chen&background=4CAF50&color=fff" alt="User">
                            <div class="request-user-info">
                                <h4>Michael Chen</h4>
                                <span class="request-status pending">Pending</span>
                            </div>
                        </div>
                        <div class="request-details">
                            <div class="detail-item">
                                <i class="fas fa-concierge-bell"></i>
                                <span>Cat Boarding</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-calendar"></i>
                                <span>15-18 Des 2024 (3 hari)</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-cat"></i>
                                <span>1 kucing (Milo)</span>
                            </div>
                        </div>
                        <div class="request-actions">
                            <button class="btn-accept">
                                <i class="fas fa-check"></i> Terima
                            </button>
                            <button class="btn-reject">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </div>
                    </div>

                    <!-- Request Item 2 -->
                    <div class="request-item pending">
                        <div class="request-header">
                            <img src="https://ui-avatars.com/api/?name=Lisa+Anderson&background=2196F3&color=fff" alt="User">
                            <div class="request-user-info">
                                <h4>Lisa Anderson</h4>
                                <span class="request-status pending">Pending</span>
                            </div>
                        </div>
                        <div class="request-details">
                            <div class="detail-item">
                                <i class="fas fa-concierge-bell"></i>
                                <span>Daily Visit</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-calendar"></i>
                                <span>20-25 Des 2024 (5 hari)</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-cat"></i>
                                <span>2 kucing (Luna & Max)</span>
                            </div>
                        </div>
                        <div class="request-actions">
                            <button class="btn-accept">
                                <i class="fas fa-check"></i> Terima
                            </button>
                            <button class="btn-reject">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </div>
                    </div>

                    <!-- Request Item 3 -->
                    <div class="request-item accepted">
                        <div class="request-header">
                            <img src="https://ui-avatars.com/api/?name=John+Smith&background=FF9800&color=fff" alt="User">
                            <div class="request-user-info">
                                <h4>John Smith</h4>
                                <span class="request-status accepted">Diterima</span>
                            </div>
                        </div>
                        <div class="request-details">
                            <div class="detail-item">
                                <i class="fas fa-concierge-bell"></i>
                                <span>Cat Sitting</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-calendar"></i>
                                <span>10-12 Des 2024 (2 hari)</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-cat"></i>
                                <span>1 kucing (Whiskers)</span>
                            </div>
                        </div>
                        <div class="request-footer">
                            <span class="accepted-text">
                                <i class="fas fa-check-circle"></i> Anda telah menerima request ini
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Bookings Preview -->
    <div class="upcoming-bookings-card">
        <div class="card-header">
            <h2>📅 Booking Mendatang</h2>
            <a href="#" class="view-all-link">Lihat Semua →</a>
        </div>
        <div class="card-body">
            <div class="booking-timeline">
                <!-- Booking Item 1 -->
                <div class="booking-item">
                    <div class="booking-date">
                        <div class="date-box">
                            <span class="day">01</span>
                            <span class="month">Des</span>
                        </div>
                    </div>
                    <div class="booking-info">
                        <h4>Sarah Williams - Cat Sitting</h4>
                        <div class="booking-meta">
                            <span><i class="fas fa-clock"></i> 09:00 - 18:00</span>
                            <span><i class="fas fa-cat"></i> Bella & Charlie</span>
                            <span><i class="fas fa-map-marker-alt"></i> South Jakarta</span>
                        </div>
                    </div>
                    <div class="booking-status ongoing">Besok</div>
                </div>

                <!-- Booking Item 2 -->
                <div class="booking-item">
                    <div class="booking-date">
                        <div class="date-box">
                            <span class="day">05</span>
                            <span class="month">Des</span>
                        </div>
                    </div>
                    <div class="booking-info">
                        <h4>David Martinez - Cat Boarding</h4>
                        <div class="booking-meta">
                            <span><i class="fas fa-clock"></i> 3 hari</span>
                            <span><i class="fas fa-cat"></i> Oliver</span>
                            <span><i class="fas fa-map-marker-alt"></i> Central Jakarta</span>
                        </div>
                    </div>
                    <div class="booking-status upcoming">5 hari lagi</div>
                </div>

                <!-- Booking Item 3 -->
                <div class="booking-item">
                    <div class="booking-date">
                        <div class="date-box">
                            <span class="day">10</span>
                            <span class="month">Des</span>
                        </div>
                    </div>
                    <div class="booking-info">
                        <h4>Emma Thompson - Daily Visit</h4>
                        <div class="booking-meta">
                            <span><i class="fas fa-clock"></i> 5 hari</span>
                            <span><i class="fas fa-cat"></i> Simba</span>
                            <span><i class="fas fa-map-marker-alt"></i> North Jakarta</span>
                        </div>
                    </div>
                    <div class="booking-status upcoming">10 hari lagi</div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{asset('js/sitter/dashboard-sitter.js')}}"></script>
@endsection