// ========================================
// SITTER DASHBOARD JAVASCRIPT - CATS STAY
// ========================================

// ===== CURRENT DATE DISPLAY =====
function displayCurrentDate() {
    const dateElement = document.getElementById('current-date');
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    };
    const today = new Date();
    const formattedDate = today.toLocaleDateString('id-ID', options);
    dateElement.textContent = formattedDate;
}

// ===== EARNINGS DATA BY PERIOD =====
const earningsData = {
    today: {
        amount: 'Rp 450.000',
        date: 'Hari Ini, 30 November 2024'
    },
    yesterday: {
        amount: 'Rp 380.000',
        date: 'Kemarin, 29 November 2024'
    },
    month: {
        amount: 'Rp 8.750.000',
        date: 'November 2024'
    }
};

// ===== EARNINGS PERIOD SWITCHER =====
function setupEarningsSwitcher() {
    const earningsButtons = document.querySelectorAll('.earnings-btn');
    const statNumber = document.querySelector('.stat-card:nth-child(2) .stat-number');
    
    earningsButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            earningsButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get period
            const period = this.getAttribute('data-period');
            
            // Update earnings display with animation
            statNumber.style.opacity = '0';
            statNumber.style.transform = 'translateY(-10px)';
            
            setTimeout(() => {
                statNumber.textContent = earningsData[period].amount;
                statNumber.style.opacity = '1';
                statNumber.style.transform = 'translateY(0)';
            }, 200);
        });
    });
}

// ===== CHART DATA =====
const chartDataSets = {
    6: {
        labels: ['Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov'],
        data: [1850000, 2100000, 1950000, 2300000, 2050000, 2200000],
        total: 'Rp 12.450.000',
        average: 'Rp 2.075.000'
    },
    12: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        data: [1500000, 1650000, 1800000, 1750000, 1900000, 1850000, 2100000, 1950000, 2300000, 2050000, 2200000, 1800000],
        total: 'Rp 22.850.000',
        average: 'Rp 1.904.167'
    },
    3: {
        labels: ['Sep', 'Okt', 'Nov'],
        data: [2300000, 2050000, 2200000],
        total: 'Rp 6.550.000',
        average: 'Rp 2.183.333'
    }
};

// ===== EARNINGS CHART =====
let earningsChart;

function createEarningsChart() {
    const ctx = document.getElementById('earningsChart').getContext('2d');
    
    earningsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartDataSets[6].labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: chartDataSets[6].data,
                backgroundColor: 'rgba(255, 152, 0, 0.6)',
                borderColor: 'rgba(255, 152, 0, 1)',
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: 'rgba(255, 152, 0, 0.8)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000000) + 'jt';
                        },
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            size: 12,
                            weight: '600'
                        }
                    }
                }
            }
        }
    });
}

// ===== CHART PERIOD SELECTOR =====
function setupChartPeriodSelector() {
    const selector = document.getElementById('chart-period');
    
    selector.addEventListener('change', function() {
        const months = parseInt(this.value);
        const dataSet = chartDataSets[months];
        
        // Update chart data
        earningsChart.data.labels = dataSet.labels;
        earningsChart.data.datasets[0].data = dataSet.data;
        earningsChart.update();
        
        // Update summary
        updateChartSummary(dataSet);
    });
}

function updateChartSummary(dataSet) {
    const totalElement = document.querySelector('.summary-value');
    const averageElement = document.querySelectorAll('.summary-value')[1];
    
    totalElement.textContent = dataSet.total;
    averageElement.textContent = dataSet.average;
}

// ===== MOBILE MENU TOGGLE =====
function setupMobileMenu() {
    const menuBtn = document.querySelector('.mobile-menu-btn');
    const sidebar = document.querySelector('.sidebar');
    
    if (menuBtn) {
        menuBtn.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
        
        // Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            if (!sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        });
    }
}

// ===== NOTIFICATION MARK AS READ =====
function setupNotifications() {
    const markReadBtn = document.querySelector('.mark-read-btn');
    const notificationItems = document.querySelectorAll('.notification-item.new');
    
    if (markReadBtn) {
        markReadBtn.addEventListener('click', function() {
            notificationItems.forEach(item => {
                item.classList.remove('new');
                item.style.opacity = '0.7';
                
                setTimeout(() => {
                    item.style.opacity = '1';
                }, 300);
            });
            
            // Update notification badge
            const notifBadge = document.querySelector('.notif-badge');
            if (notifBadge) {
                notifBadge.textContent = '0';
                setTimeout(() => {
                    notifBadge.style.display = 'none';
                }, 500);
            }
        });
    }
}

// ===== NOTIFICATION ACTION BUTTONS =====
function setupNotificationActions() {
    const notifActionBtns = document.querySelectorAll('.notif-action');
    
    notifActionBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const notification = this.closest('.notification-item');
            const title = notification.querySelector('h4').textContent;
            
            // Simulate opening detail (you can replace with actual navigation)
            alert('Membuka detail: ' + title);
        });
    });
}

// ===== REQUEST ACTIONS =====
function setupRequestActions() {
    const acceptBtns = document.querySelectorAll('.btn-accept');
    const rejectBtns = document.querySelectorAll('.btn-reject');
    
    acceptBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const requestItem = this.closest('.request-item');
            const userName = requestItem.querySelector('h4').textContent;
            
            if (confirm(`Terima request dari ${userName}?`)) {
                // Change status
                requestItem.classList.remove('pending');
                requestItem.classList.add('accepted');
                
                // Update status badge
                const statusBadge = requestItem.querySelector('.request-status');
                statusBadge.textContent = 'Diterima';
                statusBadge.classList.remove('pending');
                statusBadge.classList.add('accepted');
                
                // Replace actions with accepted message
                const actions = requestItem.querySelector('.request-actions');
                actions.outerHTML = `
                    <div class="request-footer">
                        <span class="accepted-text">
                            <i class="fas fa-check-circle"></i> Anda telah menerima request ini
                        </span>
                    </div>
                `;
                
                // Update badge count
                updateRequestBadge(-1);
                
                // Show success message
                showSuccessMessage('Request berhasil diterima!');
            }
        });
    });
    
    rejectBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const requestItem = this.closest('.request-item');
            const userName = requestItem.querySelector('h4').textContent;
            
            if (confirm(`Tolak request dari ${userName}?`)) {
                // Fade out and remove
                requestItem.style.opacity = '0';
                requestItem.style.transform = 'translateX(-20px)';
                
                setTimeout(() => {
                    requestItem.remove();
                }, 300);
                
                // Update badge count
                updateRequestBadge(-1);
                
                // Show info message
                showSuccessMessage('Request ditolak');
            }
        });
    });
}

// ===== UPDATE REQUEST BADGE =====
function updateRequestBadge(change) {
    const badge = document.querySelector('.nav-item .badge');
    if (badge) {
        let currentCount = parseInt(badge.textContent);
        currentCount += change;
        
        if (currentCount > 0) {
            badge.textContent = currentCount;
        } else {
            badge.remove();
        }
    }
    
    // Also update stat card
    const statNumber = document.querySelector('.stat-card:nth-child(3) .stat-number');
    if (statNumber) {
        let currentStat = parseInt(statNumber.textContent);
        currentStat += change;
        statNumber.textContent = Math.max(0, currentStat);
    }
}

// ===== SUCCESS MESSAGE =====
function showSuccessMessage(message) {
    const messageDiv = document.createElement('div');
    messageDiv.className = 'success-message';
    messageDiv.innerHTML = `
        <i class="fas fa-check-circle"></i>
        <span>${message}</span>
    `;
    messageDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #4CAF50;
        color: white;
        padding: 16px 24px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        animation: slideIn 0.3s ease;
    `;
    
    document.body.appendChild(messageDiv);
    
    setTimeout(() => {
        messageDiv.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            messageDiv.remove();
        }, 300);
    }, 3000);
}

// ===== ACTION BUTTONS NAVIGATION =====
function setupActionButtons() {
    const actionButtons = document.querySelectorAll('.action-btn');
    
    actionButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const actionType = this.classList[1]; // schedule, services, profile, earnings
            
            // Simulate navigation (replace with actual routing)
            alert(`Navigasi ke: ${this.querySelector('h4').textContent}`);
        });
    });
}

// ===== ADD CSS ANIMATIONS =====
function addAnimations() {
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        .stat-number {
            transition: all 0.3s ease;
        }
    `;
    document.head.appendChild(style);
}

// ===== INITIALIZE ALL FUNCTIONS =====
document.addEventListener('DOMContentLoaded', function() {
    console.log('🐱 Cats Stay - Sitter Dashboard Initialized');
    
    // Display current date
    displayCurrentDate();
    
    // Setup earnings switcher
    setupEarningsSwitcher();
    
    // Create earnings chart
    createEarningsChart();
    
    // Setup chart period selector
    setupChartPeriodSelector();
    
    // Setup mobile menu
    setupMobileMenu();
    
    // Setup notifications
    setupNotifications();
    setupNotificationActions();
    
    // Setup request actions
    setupRequestActions();
    
    // Setup action buttons
    setupActionButtons();
    
    // Add animations
    addAnimations();
    
    console.log('✅ All dashboard features loaded successfully!');
});

// ===== HELPER FUNCTIONS =====

// Format currency
function formatCurrency(amount) {
    return 'Rp ' + amount.toLocaleString('id-ID');
}

// Format date
function formatDate(dateString) {
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    };
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', options);
}

// Auto-refresh stats (optional - every 5 minutes)
function autoRefreshStats() {
    setInterval(() => {
        console.log('🔄 Auto-refreshing stats...');
        // Add AJAX call here to fetch updated stats
    }, 300000); // 5 minutes
}

// Uncomment to enable auto-refresh
// autoRefreshStats();