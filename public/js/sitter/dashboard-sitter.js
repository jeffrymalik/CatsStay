/* ========================================
   SITTER DASHBOARD JAVASCRIPT - CATS STAY
   Modern & Interactive Features
   ======================================== */

// ===== GLOBAL VARIABLES =====
let earningsChart = null;

// ===== DOM CONTENT LOADED =====
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all features
    initCurrentDate();
    initCounterAnimations();
    initEarningsSelector();
    initEarningsChart();
    initChartPeriodSelector();
    initMarkAllRead();
    initRequestActions();
    initNotificationActions();
});

// ===== DISPLAY CURRENT DATE =====
function initCurrentDate() {
    const dateElement = document.getElementById('current-date');
    if (!dateElement) return;

    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    };
    
    const today = new Date();
    dateElement.textContent = today.toLocaleDateString('en-US', options);
}

// ===== COUNTER ANIMATIONS =====
function initCounterAnimations() {
    const counters = document.querySelectorAll('.stat-number[data-target]');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000; // 2 seconds
        const increment = target / (duration / 16); // 60 FPS
        let current = 0;

        const updateCounter = () => {
            current += increment;
            
            if (current < target) {
                counter.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };

        // Start animation when element is in viewport
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        observer.observe(counter.closest('.stat-card'));
    });
}

// ===== EARNINGS SELECTOR (Today, Yesterday, Month) =====
function initEarningsSelector() {
    const earningsButtons = document.querySelectorAll('.earnings-btn');
    const earningsDisplay = document.getElementById('earnings-display');
    
    if (!earningsButtons.length || !earningsDisplay) return;

    earningsButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            earningsButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get amount from data attribute
            const amount = parseInt(this.getAttribute('data-amount'));
            
            // Animate the earnings display
            animateEarningsChange(earningsDisplay, amount);
        });
    });
}

function animateEarningsChange(element, targetAmount) {
    // Get current amount
    const currentText = element.textContent.replace(/[^0-9]/g, '');
    const currentAmount = parseInt(currentText) || 0;
    
    const duration = 800;
    const steps = 30;
    const stepDuration = duration / steps;
    const increment = (targetAmount - currentAmount) / steps;
    let current = currentAmount;
    let step = 0;

    const animate = () => {
        step++;
        current += increment;
        
        if (step < steps) {
            element.textContent = 'Rp ' + formatNumber(Math.floor(current));
            setTimeout(animate, stepDuration);
        } else {
            element.textContent = 'Rp ' + formatNumber(targetAmount);
        }
    };

    // Add pulse effect
    element.style.transform = 'scale(1.1)';
    setTimeout(() => {
        element.style.transform = 'scale(1)';
    }, 200);

    animate();
}

function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// ===== EARNINGS CHART INITIALIZATION =====
function initEarningsChart() {
    const chartCanvas = document.getElementById('earningsChart');
    if (!chartCanvas) return;

    const ctx = chartCanvas.getContext('2d');

    // Default data (6 months)
    const defaultData = {
        labels: ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
        data: [1850000, 2100000, 1950000, 2300000, 2050000, 2200000]
    };

    earningsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: defaultData.labels,
            datasets: [{
                label: 'Earnings (Rp)',
                data: defaultData.data,
                backgroundColor: 'rgba(255, 152, 0, 0.1)',
                borderColor: '#FF9800',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#FF9800',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#F57C00',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleColor: '#fff',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyColor: '#fff',
                    bodyFont: {
                        size: 13
                    },
                    borderColor: '#FF9800',
                    borderWidth: 1,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + formatNumber(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000000) + 'M';
                        },
                        color: '#999',
                        font: {
                            size: 11
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: '#666',
                        font: {
                            size: 12,
                            weight: '600'
                        }
                    },
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            }
        }
    });
}

// ===== CHART PERIOD SELECTOR =====
function initChartPeriodSelector() {
    const periodSelector = document.getElementById('chart-period');
    if (!periodSelector) return;

    periodSelector.addEventListener('change', function() {
        const period = this.value;
        updateEarningsChart(period);
    });
}

function updateEarningsChart(period) {
    // Show loading state
    const chartCard = document.querySelector('.chart-card');
    chartCard.style.opacity = '0.6';

    // Fetch data from server
    fetch(`/pet-sitter/earnings/data?period=${period}`)
        .then(response => response.json())
        .then(data => {
            // Update chart
            earningsChart.data.labels = data.labels;
            earningsChart.data.datasets[0].data = data.data;
            earningsChart.update('active');

            // Update summary
            updateChartSummary(data.total, data.average);

            // Remove loading state
            chartCard.style.opacity = '1';
        })
        .catch(error => {
            console.error('Error fetching earnings data:', error);
            chartCard.style.opacity = '1';
            
            // Show error notification
            showNotification('Failed to load earnings data', 'error');
        });
}

function updateChartSummary(total, average) {
    const totalElement = document.getElementById('total-earnings');
    const avgElement = document.getElementById('avg-earnings');

    if (totalElement) {
        totalElement.textContent = 'Rp ' + formatNumber(total);
        totalElement.style.transform = 'scale(1.1)';
        setTimeout(() => {
            totalElement.style.transform = 'scale(1)';
        }, 200);
    }

    if (avgElement) {
        avgElement.textContent = 'Rp ' + formatNumber(average);
        avgElement.style.transform = 'scale(1.1)';
        setTimeout(() => {
            avgElement.style.transform = 'scale(1)';
        }, 200);
    }
}

// ===== MARK ALL NOTIFICATIONS AS READ =====
function initMarkAllRead() {
    const markReadBtn = document.getElementById('mark-all-read');
    if (!markReadBtn) return;

    markReadBtn.addEventListener('click', function() {
        // Show confirmation
        if (!confirm('Mark all notifications as read?')) return;

        // Send AJAX request
        fetch('/pet-sitter/notifications/mark-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove 'new' class from all notifications
                const newNotifications = document.querySelectorAll('.notification-item.new');
                newNotifications.forEach(notification => {
                    notification.classList.remove('new');
                    notification.style.animation = 'fadeOut 0.3s ease';
                    setTimeout(() => {
                        notification.style.animation = '';
                        notification.classList.add('read');
                    }, 300);
                });

                showNotification('All notifications marked as read', 'success');
            }
        })
        .catch(error => {
            console.error('Error marking notifications:', error);
            showNotification('Failed to mark notifications', 'error');
        });
    });
}

// ===== REQUEST ACTIONS (Accept/Reject) =====
function initRequestActions() {
    // Accept buttons
    const acceptButtons = document.querySelectorAll('.btn-accept');
    acceptButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const form = this.closest('form');
            if (!form) return;

            // Show confirmation
            if (confirm('Accept this booking request?')) {
                // Add loading state
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Accepting...';
                
                // Submit form
                form.submit();
            }
        });
    });

    // Reject buttons
    const rejectButtons = document.querySelectorAll('.btn-reject');
    rejectButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const form = this.closest('form');
            if (!form) return;

            // Show confirmation with reason
            const reason = prompt('Please provide a reason for rejection (optional):');
            if (reason !== null) { // null means cancelled
                // Add loading state
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Rejecting...';
                
                // Add reason to form if provided
                if (reason) {
                    const reasonInput = document.createElement('input');
                    reasonInput.type = 'hidden';
                    reasonInput.name = 'reason';
                    reasonInput.value = reason;
                    form.appendChild(reasonInput);
                }
                
                // Submit form
                form.submit();
            }
        });
    });
}

// ===== NOTIFICATION ACTIONS =====
function initNotificationActions() {
    const notificationItems = document.querySelectorAll('.notification-item');
    
    notificationItems.forEach(item => {
        const viewButton = item.querySelector('.notif-action');
        
        if (viewButton) {
            viewButton.addEventListener('click', function(e) {
                e.stopPropagation();
                
                // Get notification type
                const notifIcon = item.querySelector('.notif-icon');
                const notifType = notifIcon.classList.contains('request') ? 'request' :
                                 notifIcon.classList.contains('booking') ? 'booking' : 'review';
                
                // Handle different notification types
                if (notifType === 'request') {
                    // Scroll to requests section
                    const requestsCard = document.querySelector('.recent-requests-card');
                    if (requestsCard) {
                        requestsCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        requestsCard.style.animation = 'pulse 0.5s ease';
                        setTimeout(() => {
                            requestsCard.style.animation = '';
                        }, 500);
                    }
                } else if (notifType === 'booking') {
                    // Scroll to upcoming bookings
                    const bookingsCard = document.querySelector('.upcoming-bookings-card');
                    if (bookingsCard) {
                        bookingsCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        bookingsCard.style.animation = 'pulse 0.5s ease';
                        setTimeout(() => {
                            bookingsCard.style.animation = '';
                        }, 500);
                    }
                } else {
                    // For reviews, could redirect to reviews page
                    showNotification('Review details coming soon!', 'info');
                }
                
                // Mark notification as read
                item.classList.remove('new');
            });
        }
        
        // Click entire notification item
        item.addEventListener('click', function() {
            // Remove 'new' status
            this.classList.remove('new');
        });
    });
}

// ===== UTILITY: SHOW NOTIFICATION =====
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `toast-notification ${type}`;
    notification.innerHTML = `
        <div class="toast-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
    `;

    // Add to body
    document.body.appendChild(notification);

    // Trigger animation
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);

    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// ===== ADD TOAST NOTIFICATION STYLES =====
const toastStyles = document.createElement('style');
toastStyles.textContent = `
    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        padding: 16px 24px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        z-index: 10000;
        transform: translateX(400px);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .toast-notification.show {
        transform: translateX(0);
        opacity: 1;
    }

    .toast-notification.success {
        border-left: 4px solid #4CAF50;
    }

    .toast-notification.error {
        border-left: 4px solid #F44336;
    }

    .toast-notification.info {
        border-left: 4px solid #2196F3;
    }

    .toast-content {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        font-weight: 600;
        color: #333;
    }

    .toast-content i {
        font-size: 18px;
    }

    .toast-notification.success .toast-content i {
        color: #4CAF50;
    }

    .toast-notification.error .toast-content i {
        color: #F44336;
    }

    .toast-notification.info .toast-content i {
        color: #2196F3;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0.5; }
    }
`;
document.head.appendChild(toastStyles);

// ===== SMOOTH SCROLL FOR ANCHOR LINKS =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// ===== LAZY LOAD IMAGES =====
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    });

    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// ===== HANDLE WINDOW RESIZE =====
let resizeTimer;
window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
        if (earningsChart) {
            earningsChart.resize();
        }
    }, 250);
});

// ===== LOG INITIALIZATION =====
console.log('%c🐱 Cats Stay Dashboard Initialized', 'color: #FF9800; font-size: 16px; font-weight: bold;');
console.log('%cDashboard features loaded successfully!', 'color: #4CAF50; font-size: 12px;');