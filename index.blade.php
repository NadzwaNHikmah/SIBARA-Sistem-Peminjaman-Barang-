@extends('layouts.app')

@section('content')
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="page-title">Data Pengguna</h1>
            <p class="page-subtitle">Kelola akses dan informasi pengguna sistem</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus me-2"></i>
                Tambah User
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
{{--<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $totalUsers }}</h3>
                <p>Total Pengguna</p>
            </div>
        </div>
    </div>
</div>--}}


<!-- Search & Filter Card -->
<div class="card search-card mb-4">
    <div class="card-body">
        <form action="{{ route('users.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                {{-- Input Pencarian --}}
                <div class="col-lg-8 col-md-7">
                    <label class="form-label">Cari Pengguna</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Cari berdasarkan nama atau email..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                {{-- Tombol Terapkan Filter --}}
                <div class="col-lg-2 col-md-3">
                    <label class="form-label d-none d-md-block">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>
                        Terapkan Filter
                    </button>
                </div>

                {{-- Tombol Reset Filter --}}
                <div class="col-lg-2 col-md-2">
                    <label class="form-label d-none d-md-block">&nbsp;</label>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-refresh me-2"></i>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Alert Notification -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Main Data Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-list me-2"></i>
            Daftar Pengguna Sistem
        </h5>
        <div class="badge bg-primary">
            {{ $users->total() }} Pengguna
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th>Pengguna</th>
                        <th>Informasi</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="align-middle">
                        <td class="text-center">
                            <span class="badge bg-light text-dark">{{ $users->firstItem() + $loop->index }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-3">
                                    <div class="avatar-initials bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                         style="width: 40px; height: 40px; font-size: 14px; font-weight: 600;">
                                        {{ getInitials($user->name) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                    <small class="text-muted">
                                        @if($user->role == 'admin')
                                            <i class="fas fa-crown text-warning me-1"></i>
                                        @else
                                            <i class="fas fa-user me-1"></i>
                                        @endif
                                        {{ ucfirst($user->role) }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold text-primary">{{ $user->email }}</div>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                Bergabung {{ $user->created_at->diffForHumans() }}
                            </small>
                        </td>

                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('users.edit', $user->id) }}" 
                                   class="btn btn-outline-warning btn-sm" 
                                   data-bs-toggle="tooltip" 
                                   data-bs-title="Edit Pengguna">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('users.show', $user->id) }}" 
                                    class="btn btn-outline-info btn-sm" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-title="Detail Instansi">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($user->id !== Auth::id())
                                <form action="{{ route('users.destroy', $user->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirmDelete('{{ $user->name }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-outline-danger btn-sm" 
                                            data-bs-toggle="tooltip" 
                                            data-bs-title="Hapus Pengguna">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-outline-secondary btn-sm" disabled
                                        data-bs-toggle="tooltip" 
                                        data-bs-title="Tidak dapat menghapus akun sendiri">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Tidak ada data pengguna</h5>
                                <p class="text-muted">Mulai dengan menambahkan pengguna baru ke sistem</p>
                                <a href="{{ route('users.create') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus me-2"></i>
                                    Tambah Pengguna Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted">
                Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} pengguna
            </div>
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- User Detail Modal -->
<div class="modal fade" id="userDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user me-2"></i>
                    Detail Pengguna
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="userDetailContent">
                <!-- Content will be loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    border: 1px solid #f8f9fa;
    transition: transform 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-icon.primary { background: #e3f2fd; color: #1976d2; }
.stat-icon.success { background: #e8f5e8; color: #2e7d32; }
.stat-icon.warning { background: #fff3e0; color: #f57c00; }
.stat-icon.info { background: #f3e5f5; color: #7b1fa2; }

.stat-content h3 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 5px;
    line-height: 1;
}

.stat-content p {
    color: #6c757d;
    margin: 0;
    font-size: 0.9rem;
}

.search-card {
    border: 1px solid #e3e6f0;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
}

.card {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.card-header {
    background: white;
    border-bottom: 1px solid #e3e6f0;
    padding: 20px 25px;
    border-radius: 16px 16px 0 0 !important;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-title {
    font-weight: 600;
    color: #2d3748;
    margin: 0;
}

.table {
    margin: 0;
}

.table th {
    border-bottom: 1px solid #e3e6f0;
    font-weight: 600;
    color: #4a5568;
    padding: 15px 12px;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table td {
    padding: 15px 12px;
    vertical-align: middle;
    border-bottom: 1px solid #f7fafc;
}

.table-hover tbody tr:hover {
    background-color: #f8fafc;
}

.avatar-initials {
    font-weight: 600;
}

.empty-state {
    padding: 40px 20px;
}

.btn-group .btn {
    border-radius: 8px !important;
    margin: 0 2px;
}

.card-footer {
    background: white;
    border-top: 1px solid #e3e6f0;
    padding: 20px 25px;
    border-radius: 0 0 16px 16px;
}

.pagination {
    margin: 0;
}

.badge {
    font-weight: 500;
    padding: 6px 12px;
    border-radius: 8px;
}

.alert {
    border: none;
    border-radius: 12px;
    padding: 16px 20px;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.input-group {
    border-radius: 12px;
    overflow: hidden;
}

.input-group-text {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #64748b;
}

.form-control {
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

.btn {
    border-radius: 12px;
    padding: 10px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    border: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
}

.modal-content {
    border: none;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.modal-header {
    border-bottom: 1px solid #e3e6f0;
    padding: 20px 25px;
    border-radius: 16px 16px 0 0 !important;
}

.modal-body {
    padding: 25px;
}

@media (max-width: 768px) {
    .page-header {
        margin: -20px -15px 30px -15px;
        padding: 25px 20px;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .stat-card {
        padding: 15px;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    .table-responsive {
        border-radius: 0 0 16px 16px;
    }
    
    .btn-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    .btn-group .btn {
        margin: 0;
    }
    
    .card-header {
        flex-direction: column;
        gap: 10px;
        align-items: start;
    }
}
</style>

<script>
// Helper function for initials
function getInitials(name) {
    if (!name) return '?';
    return name.split(' ')
        .map(part => part.charAt(0))
        .join('')
        .toUpperCase()
        .substring(0, 2);
}

// Delete confirmation with user name
function confirmDelete(userName) {
    return confirm(`Apakah Anda yakin ingin menghapus pengguna "${userName}"? Tindakan ini tidak dapat dibatalkan.`);
}

// Show user detail modal
function showUserDetail(userId) {
    // In a real application, you would fetch user details via AJAX
    // For now, we'll show a simple message
    const modalContent = document.getElementById('userDetailContent');
    modalContent.innerHTML = `
        <div class="text-center">
            <div class="avatar-lg mx-auto mb-3">
                <div class="avatar-initials bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                     style="width: 80px; height: 80px; font-size: 24px; font-weight: 600;">
                    ${getInitials('{{ $user->name ?? "User" }}')}
                </div>
            </div>
            <h5 class="mb-2">{{ $user->name ?? "User" }}</h5>
            <p class="text-muted mb-3">{{ $user->email ?? "email@example.com" }}</p>
        
            
            <div class="mt-4 pt-3 border-top">
                <small class="text-muted">Bergabung</small>
                <div class="fw-semibold">{{ $user->created_at->format('d M Y H:i') ?? 'Tidak tersedia' }}</div>
            </div>
        </div>
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('userDetailModal'));
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Add loading state to delete buttons
    const deleteForms = document.querySelectorAll('form[onsubmit]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...';
                submitBtn.disabled = true;
            }
        });
    });

    // Auto-focus search input
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput && !searchInput.value) {
        setTimeout(() => searchInput.focus(), 300);
    }
});
</script>
@endsection