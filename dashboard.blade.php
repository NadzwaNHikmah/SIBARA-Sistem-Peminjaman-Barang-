@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- Welcome Section -->
    <div class="welcome-section mb-5">
        <div class="welcome-card">
            <div class="welcome-content">
                <div class="welcome-text">
                    <h1 class="welcome-title">Selamat Datang, <span class="text-gradient">{{ auth()->user()->name }}</span>! 👋</h1>
                    <p class="welcome-subtitle">Senang melihat Anda kembali. Berikut adalah ringkasan aktivitas sistem peminjaman barang hari ini.</p>
                    <div class="welcome-stats">
                        <div class="stat-item">
                            <i class="fas fa-calendar-day text-primary"></i>
                            <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-clock text-success"></i>
                            <span>{{ \Carbon\Carbon::now()->format('H:i') }} WIB</span>
                        </div>
                    </div>
                </div>
                <div class="welcome-graphic">
                    <div class="logo-containers">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo SIBARA" class="logo-imge">
                    </div>
                    <div class="graphic-element">
                        <div class="circle circle-1"></div>
                        <div class="circle circle-2"></div>
                        <div class="circle circle-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-section mb-5">
        <div class="row g-4">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card card-primary">
                    <div class="card-glow"></div>
                    <div class="stat-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($totalBarang) }}</h3>
                        <p class="stat-label">Total Barang</p>
                        <div class="stat-trend">
                            <i class="fas fa-chart-line-up"></i>
                            <span>Semua barang terdata</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="stat-card card-success">
                    <div class="card-glow"></div>
                    <div class="stat-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($totalInstansi) }}</h3>
                        <p class="stat-label">Total Instansi</p>
                        <div class="stat-trend">
                            <i class="fas fa-handshake"></i>
                            <span>Mitra terdaftar</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="stat-card card-warning">
                    <div class="card-glow"></div>
                    <div class="stat-icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($totalTransaksi) }}</h3>
                        <p class="stat-label">Total Transaksi</p>
                        <div class="stat-trend">
                            <i class="fas fa-history"></i>
                            <span>Riwayat peminjaman</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="stat-card card-danger">
                    <div class="card-glow"></div>
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ number_format($totalUser) }}</h3>
                        <p class="stat-label">Total User</p>
                        <div class="stat-trend">
                            <i class="fas fa-user-check"></i>
                            <span>Pengguna aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & System Status -->
    <div class="features-section">
        <div class="row g-4">
            <!-- Quick Actions -->
            <div class="col-lg-6">
                <div class="feature-card">
                    <div class="card-header">
                        <div class="header-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="header-content">
                            <h5 class="card-title">Akses Cepat</h5>
                            <p class="card-subtitle">Fitur-fitur utama sistem</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions">
                            <a href="{{ route('barang.index') }}" class="quick-action-item">
                                <div class="action-icon primary">
                                    <i class="fas fa-boxes"></i>
                                </div>
                                <div class="action-content">
                                    <h6>Kelola Barang</h6>
                                    <p>Data inventaris barang</p>
                                </div>
                                <div class="action-arrow">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                            
                            <a href="{{ route('transaksi.index') }}" class="quick-action-item">
                                <div class="action-icon success">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                                <div class="action-content">
                                    <h6>Transaksi</h6>
                                    <p>Peminjaman & pengembalian</p>
                                </div>
                                <div class="action-arrow">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                            
                            <a href="{{ route('instansi.index') }}" class="quick-action-item">
                                <div class="action-icon warning">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div class="action-content">
                                    <h6>Instansi</h6>
                                    <p>Mitra peminjam</p>
                                </div>
                                <div class="action-arrow">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                            
                            <a href="{{ route('users.index') }}" class="quick-action-item">
                                <div class="action-icon danger">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="action-content">
                                    <h6>Manajemen User</h6>
                                    <p>Pengguna sistem</p>
                                </div>
                                <div class="action-arrow">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary: #3b82f6;
    --primary-light: #60a5fa;
    --primary-dark: #1d4ed8;
    --success: #10b981;
    --success-light: #34d399;
    --warning: #f59e0b;
    --warning-light: #fbbf24;
    --danger: #ef4444;
    --danger-light: #f87171;
    --dark: #1e293b;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-300: #cbd5e1;
    --gray-400: #94a3b8;
    --gray-500: #64748b;
    --gray-600: #475569;
    --gray-700: #334155;
    --gray-800: #1e293b;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --radius: 16px;
    --radius-lg: 20px;
}

.dashboard-container {
    padding: 0;
    background: var(--gray-50);
    min-height: 100vh;
}

/* Welcome Section */
.welcome-section {
    position: relative;
}

.welcome-card {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: var(--radius-lg);
    padding: 40px;
    color: white;
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
}

.welcome-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.3;
}

.welcome-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    z-index: 1;
}

.welcome-text {
    flex: 1;
    max-width: 65%;
}

.welcome-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 15px;
    line-height: 1.2;
}

.text-gradient {
    background: linear-gradient(90deg, #fbbf24, #f87171);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.welcome-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 25px;
    max-width: 90%;
}

.welcome-stats {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.95rem;
    background: rgba(255, 255, 255, 0.15);
    padding: 8px 16px;
    border-radius: 50px;
    backdrop-filter: blur(10px);
}

.stat-item i {
    font-size: 1.1rem;
}

.welcome-graphic {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
}

.logo-containers {
    margin-top: 50px;
    z-index: 2;
}
.logo-containers {
    width: 140px;
    height: 140px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.logo-imge {
    height: 94px;
    width: auto;
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
}

.graphic-element {
    position: relative;
    width: 120px;
    height: 120px;
}

.circle {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    animation: float 6s ease-in-out infinite;
}

.circle-1 {
    width: 80px;
    height: 80px;
    top: 0;
    left: 0;
    animation-delay: 0s;
}

.circle-2 {
    width: 60px;
    height: 60px;
    bottom: 0;
    right: 0;
    animation-delay: 2s;
}

.circle-3 {
    width: 40px;
    height: 40px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

/* Statistics Cards */
.stats-section {
    position: relative;
}

.stat-card {
    background: white;
    border-radius: var(--radius);
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: var(--shadow);
    transition: all 0.4s ease;
    border: 1px solid var(--gray-100);
    height: 100%;
    position: relative;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg);
}

.card-glow {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.stat-card:hover .card-glow {
    opacity: 1;
}

.card-primary .card-glow {
    background: linear-gradient(90deg, var(--primary), var(--primary-light));
}

.card-success .card-glow {
    background: linear-gradient(90deg, var(--success), var(--success-light));
}

.card-warning .card-glow {
    background: linear-gradient(90deg, var(--warning), var(--warning-light));
}

.card-danger .card-glow {
    background: linear-gradient(90deg, var(--danger), var(--danger-light));
}

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    flex-shrink: 0;
    color: white;
    box-shadow: var(--shadow);
}

.card-primary .stat-icon {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
}

.card-success .stat-icon {
    background: linear-gradient(135deg, var(--success), var(--success-light));
}

.card-warning .stat-icon {
    background: linear-gradient(135deg, var(--warning), var(--warning-light));
}

.card-danger .stat-icon {
    background: linear-gradient(135deg, var(--danger), var(--danger-light));
}

.stat-number {
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 5px;
    line-height: 1;
    background: linear-gradient(90deg, var(--gray-800), var(--gray-600));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stat-label {
    font-size: 0.95rem;
    color: var(--gray-500);
    margin-bottom: 10px;
    font-weight: 500;
}

.stat-trend {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
    color: var(--gray-400);
}

.stat-trend i {
    font-size: 0.9rem;
}

/* Feature Cards */
.feature-card {
    background: white;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--gray-100);
    height: 100%;
    overflow: hidden;
    transition: all 0.3s ease;
}

.feature-card:hover {
    box-shadow: var(--shadow-md);
}

.card-header {
    padding: 25px 25px 0;
    border-bottom: none;
    background: transparent;
    display: flex;
    align-items: center;
    gap: 15px;
}

.header-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: white;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    box-shadow: var(--shadow);
}

.header-content {
    flex: 1;
}

.card-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 5px;
}

.card-subtitle {
    color: var(--gray-500);
    font-size: 0.9rem;
}

.card-body {
    padding: 20px 25px 25px;
}

/* Quick Actions */
.quick-actions {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.quick-action-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 16px;
    text-decoration: none;
    color: inherit;
    border-radius: 12px;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.quick-action-item:hover {
    background: var(--gray-50);
    border-color: var(--gray-200);
    transform: translateX(5px);
    box-shadow: var(--shadow-sm);
}

.action-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.quick-action-item:hover .action-icon {
    transform: scale(1.1);
}

.action-icon.primary {
    background: var(--gray-100);
    color: var(--primary);
}

.action-icon.success {
    background: var(--gray-100);
    color: var(--success);
}

.action-icon.warning {
    background: var(--gray-100);
    color: var(--warning);
}

.action-icon.danger {
    background: var(--gray-100);
    color: var(--danger);
}

.action-content {
    flex: 1;
}

.action-content h6 {
    font-weight: 600;
    margin-bottom: 4px;
    color: var(--gray-800);
}

.action-content p {
    font-size: 0.85rem;
    color: var(--gray-500);
    margin: 0;
}

.action-arrow {
    color: var(--gray-300);
    transition: all 0.3s ease;
}

.quick-action-item:hover .action-arrow {
    transform: translateX(3px);
    color: var(--primary);
}

/* System Status */
.system-status {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.status-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 18px;
    border-radius: 12px;
    background: var(--gray-50);
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.status-item:hover {
    background: white;
    border-color: var(--gray-200);
    transform: translateX(3px);
    box-shadow: var(--shadow-sm);
}

.status-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
    position: relative;
}

.status-item.online .status-indicator,
.status-item.success .status-indicator {
    background: var(--success);
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
}

.status-item.warning .status-indicator,
.status-warning .status-indicator {
    background: var(--warning);
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
}

.status-item.primary .status-indicator,
.status-info .status-indicator {
    background: var(--primary);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
}

.status-item.danger .status-indicator {
    background: var(--danger);
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);
}

.status-content h6 {
    font-weight: 600;
    margin-bottom: 4px;
    color: var(--gray-800);
}

.status-content p {
    font-size: 0.85rem;
    color: var(--gray-500);
    margin: 0;
}

.response-time {
    font-weight: 600;
    color: var(--response-color, var(--gray-500));
}

/* Responsive Design */
@media (max-width: 1200px) {
    .welcome-title {
        font-size: 2.2rem;
    }
}

@media (max-width: 992px) {
    .welcome-content {
        flex-direction: column;
        text-align: center;
    }
    
    .welcome-text {
        max-width: 100%;
        margin-bottom: 30px;
    }
    
    .welcome-stats {
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .welcome-card {
        padding: 30px 25px;
    }
    
    .welcome-title {
        font-size: 1.8rem;
    }
    
    .welcome-stats {
        gap: 15px;
    }
    
    .stat-item {
        padding: 6px 12px;
        font-size: 0.9rem;
    }
    
    .stat-card {
        padding: 20px;
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .stat-number {
        font-size: 1.8rem;
    }
    
    .card-header {
        padding: 20px 20px 0;
    }
    
    .card-body {
        padding: 15px 20px 20px;
    }
}

@media (max-width: 576px) {
    .welcome-card {
        padding: 25px 20px;
    }
    
    .welcome-title {
        font-size: 1.6rem;
    }
    
    .stat-card {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .quick-action-item {
        padding: 14px;
    }
    
    .status-item {
        padding: 16px;
    }
}
</style>

<script>
// Enhanced interactive animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate stat numbers with counting effect
    const statNumbers = document.querySelectorAll('.stat-number');
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const numberObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const stat = entry.target;
                const target = parseInt(stat.textContent.replace(/,/g, ''));
                let current = 0;
                const increment = target / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    stat.textContent = Math.floor(current).toLocaleString();
                }, 30);
                
                numberObserver.unobserve(stat);
            }
        });
    }, observerOptions);
    
    statNumbers.forEach(stat => {
        numberObserver.observe(stat);
    });

    // Add parallax effect to welcome card
    const welcomeCard = document.querySelector('.welcome-card');
    if (welcomeCard) {
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;
            welcomeCard.style.transform = `translateY(${rate}px)`;
        });
    }

    // Add hover effects to cards with delay for staggered animation
    const cards = document.querySelectorAll('.stat-card, .feature-card');
    cards.forEach((card, index) => {
        card.style.transitionDelay = `${index * 0.05}s`;
        
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Add ripple effect to quick action items
    const quickActions = document.querySelectorAll('.quick-action-item');
    quickActions.forEach(action => {
        action.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(59, 130, 246, 0.3);
                transform: scale(0);
                animation: ripple 0.6s linear;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                pointer-events: none;
            `;
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Add CSS for ripple animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection