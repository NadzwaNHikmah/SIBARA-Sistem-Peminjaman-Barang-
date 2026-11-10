@extends('layouts.app')

@section('content')
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="page-title">Detail Pengguna</h1>
            <p class="page-subtitle">Informasi lengkap dan statistik pengguna sistem</p>
        </div>
        <div class="col-auto">
            <div class="btn-group">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i> Edit Pengguna
                </a>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- Profile Card -->
        <div class="card profile-card mb-4">
            <div class="card-body text-center">
                <div class="avatar-section mb-4">
                    <div class="avatar-container mx-auto">
                        @php
                            $colors = ['#007bff', '#28a745', '#17a2b8', '#ffc107', '#dc3545', '#6f42c1', '#20c997', '#fd7e14'];
                            $bgColor = $colors[array_rand($colors)];
                        @endphp

                        <div class="avatar-initials text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                            style="width: 120px; height: 120px; font-size: 42px; font-weight: 700; background-color: {{ $bgColor }};">
                            {{ getInitials($user->name) }}
                        </div>


                    </div>
                </div>
                
                <h2 class="profile-name fw-bold mb-2">{{ $user->name }}</h2>
                <p class="profile-email text-muted mb-3">
                    <i class="fas fa-envelope me-2"></i>{{ $user->email }}
                </p>
                
                <div class="profile-badges mb-4">
                    <span class="badge role-badge {{ $user->role }}-badge">
                        <i class="fas {{ $user->role == 'admin' ? 'fa-crown' : 'fa-user' }} me-2"></i>
                        {{ ucfirst($user->role) }}
                    </span>

                </div>

                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-number text-primary">{{ $user->created_at->diffForHumans() }}</div>
                        <div class="stat-label">Hari Bergabung</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card quick-actions-card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Aksi Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-warning">
                        <i class="fas fa-edit me-2"></i> Edit Profil
                    </a>
                    @if($user->id !== Auth::id())
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-2"></i> Hapus Pengguna
                        </button>
                    </form>
                    @else
                    <button class="btn btn-outline-secondary" disabled>
                        <i class="fas fa-trash me-2"></i> Tidak Dapat Hapus Akun Sendiri
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- User Information -->
        <div class="card user-info-card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Detail
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-icon text-primary">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="info-content">
                                <label class="info-label">Nama Lengkap</label>
                                <div class="info-value">{{ $user->name }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-icon text-success">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="info-content">
                                <label class="info-label">Alamat Email</label>
                                <div class="info-value">{{ $user->email }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-icon text-warning">
                                <i class="fas fa-user-tag"></i>
                            </div>
                            <div class="info-content">
                                <label class="info-label">Role</label>
                                <div class="info-value">{{ ucfirst($user->role) }}</div>
                            </div>
                        </div>
                    </div>
    
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-icon text-purple">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <div class="info-content">
                                <label class="info-label">Bergabung Pada</label>
                                <div class="info-value">{{ $user->created_at->format('d F Y') }}</div>
                                <small class="text-muted">{{ $user->created_at->format('H:i') }} • {{ $user->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-icon text-orange">
                                <i class="fas fa-history"></i>
                            </div>
                            <div class="info-content">
                                <label class="info-label">Terakhir Diupdate</label>
                                <div class="info-value">{{ $user->updated_at->format('d F Y') }}</div>
                                <small class="text-muted">{{ $user->updated_at->format('H:i') }} • {{ $user->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.page-header {
    background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
    border-radius: 16px;
    padding: 30px;
    color: white;
    margin: -20px -20px 30px -20px;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.page-subtitle {
    opacity: 0.9;
    margin: 0;
}

.card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

/* Profile Card */
.profile-card {
    position: relative;
    overflow: hidden;
}

.profile-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #ec4899, #8b5cf6);
}

.avatar-container {
    position: relative;
    width: fit-content;
}

.avatar-initials {
    border: 4px solid white;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.status-indicator {
    position: absolute;
    bottom: 8px;
    right: 8px;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 3px solid white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

.status-indicator.online {
    background: #10b981;
    color: white;
}

.status-indicator.offline {
    background: #6b7280;
    color: white;
}

.profile-name {
    font-size: 1.5rem;
    color: #1f2937;
}

.profile-email {
    font-size: 1.1rem;
}

.profile-badges {
    display: flex;
    gap: 8px;
    justify-content: center;
    flex-wrap: wrap;
}

.badge {
    font-weight: 500;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
}

.role-badge.admin-badge {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.role-badge.petugas-badge {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
}

.role-badge.user-badge {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
}

.active-badge {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.inactive-badge {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
}

.profile-stats {
    margin-top: 20px;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 700;
    line-height: 1;
}

.stat-label {
    font-size: 0.85rem;
    color: #6b7280;
    margin-top: 4px;
}

/* Info Items */
.info-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #f3f4f6;
}

.info-item:last-child {
    border-bottom: none;
}

.info-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    background: #f8fafc;
    flex-shrink: 0;
}

.info-content {
    flex: 1;
}

.info-label {
    font-size: 0.85rem;
    color: #6b7280;
    font-weight: 500;
    margin-bottom: 4px;
}

.info-value {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
}

/* Activity Stats */
.activity-stat {
    text-align: center;
    padding: 20px 10px;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    font-size: 1.5rem;
    color: white;
}

/* Timeline */
.activity-timeline {
    position: relative;
}

.timeline-item {
    display: flex;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #f3f4f6;
}

.timeline-item:last-child {
    border-bottom: none;
}

.timeline-marker {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #8b5cf6;
    flex-shrink: 0;
}

.timeline-content {
    flex: 1;
}

.timeline-title {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 4px;
}

.timeline-description {
    color: #6b7280;
    font-size: 0.9rem;
    margin-bottom: 4px;
}

.timeline-time {
    font-size: 0.8rem;
    color: #9ca3af;
}

.status-dipinjam { background: #fef3c7; color: #92400e; }
.status-dikembalikan { background: #dcfce7; color: #166534; }
.status-menunggu { background: #f3f4f6; color: #374151; }

/* Quick Actions */
.quick-actions-card .card-body {
    padding: 20px;
}

.quick-actions-card .btn {
    border-radius: 10px;
    padding: 12px;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        margin: -20px -15px 30px -15px;
        padding: 25px 20px;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .profile-badges {
        flex-direction: column;
        align-items: center;
    }
    
    .info-item {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
    
    .info-icon {
        align-self: center;
    }
    
    .activity-stat {
        padding: 15px 5px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Helper function for initials
function getInitials(name) {
    if (!name) return '??';
    return name.split(' ')
        .map(part => part.charAt(0))
        .join('')
        .toUpperCase()
        .substring(0, 2);
}
</script>
@endsection