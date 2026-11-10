@extends('layouts.app')

@section('content')
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="page-title">Edit Pengguna</h1>
            <p class="page-subtitle">Perbarui informasi dan akses pengguna</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-edit me-2 text-warning"></i>
                    Form Edit Pengguna
                </h5>
                <div class="badge bg-light text-dark">
                    <i class="fas fa-hashtag me-1"></i>
                    ID: {{ $user->id }}
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST" id="editUserForm">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-8">
                            <!-- Informasi Akun -->
                            <div class="form-section mb-4">
                                <div class="section-header mb-3">
                                    <h6 class="section-title">
                                        <i class="fas fa-user-circle me-2 text-info"></i>
                                        Informasi Akun
                                    </h6>
                                    <div class="section-badge">Wajib</div>
                                </div>
                                
                                <div class="form-group mb-4">
                                    <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" name="name" class="form-control" 
                                               placeholder="Masukkan nama lengkap pengguna" required
                                               value="{{ old('name', $user->name) }}"
                                               id="nameInput">
                                    </div>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" name="email" class="form-control" 
                                               placeholder="contoh@email.com" required
                                               value="{{ old('email', $user->email) }}"
                                               id="emailInput">
                                    </div>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Keamanan & Role -->
                            <div class="form-section mb-4">
                                <div class="section-header mb-3">
                                    <h6 class="section-title">
                                        <i class="fas fa-shield-alt me-2 text-warning"></i>
                                        Keamanan & Akses
                                    </h6>
                                    <div class="section-badge">Opsional</div>
                                </div>
                                
                                <div class="form-group mb-4">
                                    <label class="form-label fw-semibold">Password Baru</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" name="password" class="form-control" 
                                               placeholder="Kosongkan jika tidak ingin mengubah password"
                                               id="passwordInput"
                                               minlength="8">
                                        <button type="button" class="btn btn-outline-secondary" 
                                                onclick="togglePasswordVisibility('passwordInput')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text text-muted">
                                        <small>Minimal 8 karakter. Biarkan kosong untuk mempertahankan password lama.</small>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" name="password_confirmation" class="form-control" 
                                               placeholder="Ulangi password baru"
                                               id="passwordConfirmationInput">
                                        <button type="button" class="btn btn-outline-secondary" 
                                                onclick="togglePasswordVisibility('passwordConfirmationInput')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-semibold">Role Pengguna <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user-tag"></i>
                                        </span>
                                        <select name="role" class="form-select" required>
                                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                                Administrator
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-text text-muted">
                                        <small>Pilih hak akses yang sesuai untuk pengguna</small>
                                    </div>
                                    @error('role')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Status Card -->
                            <div class="status-card">
                                <div class="status-card-header">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    Informasi Pengguna
                                </div>
                                <div class="status-card-body">
                                    <div class="status-item">
                                        <i class="fas fa-calendar-plus text-primary"></i>
                                        <div>
                                            <small class="text-muted">Bergabung</small>
                                            <div class="fw-semibold">{{ $user->created_at->format('d M Y H:i') }}</div>
                                        </div>
                                    </div>
                                    <div class="status-item">
                                        <i class="fas fa-history text-warning"></i>
                                        <div>
                                            <small class="text-muted">Terakhir Diupdate</small>
                                            <div class="fw-semibold">{{ $user->updated_at->format('d M Y H:i') }}</div>
                                        </div>
                                    </div>
                                    <div class="status-item">
                                        <i class="fas fa-user-edit text-success"></i>
                                        <div>
                                            <small class="text-muted">Diubah Oleh</small>
                                            <div class="fw-semibold">{{ Auth::user()->name }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Preview Card -->
                            <div class="preview-card mt-4">
                                <div class="preview-header">
                                    <i class="fas fa-sync-alt me-2"></i>
                                    Preview Perubahan
                                </div>
                                <div class="preview-body">
                                    <div class="preview-avatar text-center mb-3">
                                        <div class="avatar-lg mx-auto">
                                            <div class="avatar-initials bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                                 style="width: 80px; height: 80px; font-size: 24px; font-weight: 600;"
                                                 id="avatarPreview">
                                                {{ getInitials($user->name) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="preview-item">
                                        <small class="text-muted">Nama:</small>
                                        <div>
                                            <div class="text-danger text-decoration-line-through small" id="oldName">{{ $user->name }}</div>
                                            <div class="fw-semibold text-success" id="newName">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                    <div class="preview-item">
                                        <small class="text-muted">Email:</small>
                                        <div>
                                            <div class="text-danger text-decoration-line-through small" id="oldEmail">{{ $user->email }}</div>
                                            <div class="fw-semibold text-success" id="newEmail">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                    <div class="preview-item">
                                        <small class="text-muted">Role:</small>
                                        <div>
                                            <div class="text-danger text-decoration-line-through small" id="oldRole">{{ ucfirst($user->role) }}</div>
                                            <div class="fw-semibold text-success" id="newRole">{{ ucfirst($user->role) }}</div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <!-- Warning Card -->
                            @if($user->id === Auth::id())
                            <div class="warning-card mt-4">
                                <div class="warning-card-header">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Peringatan
                                </div>
                                <div class="warning-card-body">
                                    <div class="warning-item">
                                        <i class="fas fa-info-circle text-warning"></i>
                                        <span>Anda sedang mengedit akun sendiri</span>
                                    </div>
                                    <div class="warning-item">
                                        <i class="fas fa-lock text-danger"></i>
                                        <span>Perubahan akan langsung berlaku</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="fas fa-save me-2"></i>
                            Update Pengguna
                        </button>
                        <button type="reset" class="btn btn-outline-secondary btn-lg" onclick="resetForm()">
                            <i class="fas fa-undo me-2"></i>
                            Reset Perubahan
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-danger btn-lg">
                            <i class="fas fa-times me-2"></i>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.page-header {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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

.card-header {
    background: white;
    border-bottom: 1px solid #e3e6f0;
    padding: 25px 30px;
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

/* Form Sections */
.form-section {
    background: #f8fafc;
    border-radius: 12px;
    padding: 20px;
    border: 1px solid #e2e8f0;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-title {
    font-size: 1rem;
    font-weight: 600;
    color: #374151;
    margin: 0;
}

.section-badge {
    background: #f59e0b;
    color: white;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
}

.section-badge[data-badge="opsional"] {
    background: #6b7280;
}

/* Form Elements */
.form-group {
    margin-bottom: 1.5rem;
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
    min-width: 45px;
    justify-content: center;
}

.form-control, .form-select, textarea.form-control {
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus, textarea.form-control:focus {
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

.form-text {
    font-size: 0.8rem;
}

/* Status Card */
.status-card {
    background: #fffbeb;
    border: 1px solid #fcd34d;
    border-radius: 12px;
    overflow: hidden;
}

.status-card-header {
    background: #f59e0b;
    color: white;
    padding: 12px 16px;
    font-weight: 600;
    font-size: 14px;
}

.status-card-body {
    padding: 16px;
}

.status-item {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
    padding-bottom: 12px;
    border-bottom: 1px solid #fef3c7;
}

.status-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.status-item i {
    font-size: 16px;
    width: 20px;
    text-align: center;
}

/* Preview Card */
.preview-card {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
}

.preview-header {
    background: #f59e0b;
    color: white;
    padding: 12px 16px;
    font-weight: 600;
    font-size: 14px;
}

.preview-body {
    padding: 16px;
}

.preview-item {
    margin-bottom: 12px;
    padding-bottom: 12px;
    border-bottom: 1px solid #e2e8f0;
}

.preview-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.text-decoration-line-through {
    text-decoration: line-through;
}

.avatar-lg {
    margin-bottom: 15px;
}

/* Warning Card */
.warning-card {
    background: #fef3f2;
    border: 1px solid #fecaca;
    border-radius: 12px;
    overflow: hidden;
}

.warning-card-header {
    background: #ef4444;
    color: white;
    padding: 12px 16px;
    font-weight: 600;
    font-size: 14px;
}

.warning-card-body {
    padding: 16px;
}

.warning-item {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
    font-size: 13px;
    color: #7f1d1d;
}

.warning-item:last-child {
    margin-bottom: 0;
}

.warning-item i {
    width: 16px;
    text-align: center;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 12px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
    margin-top: 30px;
}

.btn {
    border-radius: 12px;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-warning {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border: none;
    color: white;
}

.btn-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.btn-outline-secondary:hover,
.btn-outline-danger:hover {
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-header {
        margin: -20px -15px 30px -15px;
        padding: 25px 20px;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .card-header {
        flex-direction: column;
        gap: 10px;
        align-items: start;
    }
    
    .form-section {
        padding: 15px;
    }
    
    .section-header {
        flex-direction: column;
        align-items: start;
        gap: 10px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
    }
    
    .status-card, .preview-card, .warning-card {
        margin-top: 20px;
    }
}

/* Animation for changes */
.preview-item div {
    transition: all 0.3s ease;
}

.changed {
    animation: highlightChange 0.6s ease;
}

@keyframes highlightChange {
    0% { background-color: transparent; }
    50% { background-color: #fef3c7; }
    100% { background-color: transparent; }
}
</style>

<script>
// Helper function for initials
function getInitials(name) {
    if (!name) return '??';
    return name.split(' ')
        .map(part => part.charAt(0))
        .join('')
        .toUpperCase()
        .substring(0, 2);
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editUserForm');
    const nameInput = document.getElementById('nameInput');
    const emailInput = document.getElementById('emailInput');
    const passwordInput = document.getElementById('passwordInput');
    const passwordConfirmationInput = document.getElementById('passwordConfirmationInput');
    const roleSelect = document.querySelector('select[name="role"]');
    
    const avatarPreview = document.getElementById('avatarPreview');
    
    // Store original values
    const originalValues = {
        name: '{{ $user->name }}',
        email: '{{ $user->email }}',
        role: '{{ $user->role }}',
        is_active: '{{ $user->is_active }}'
    };

    // Real-time changes tracking
    nameInput.addEventListener('input', function() {
        updateAvatarPreview(this.value);
        updatePreview('name', this.value);
    });

    emailInput.addEventListener('input', function() {
        updatePreview('email', this.value);
    });

    roleSelect.addEventListener('change', function() {
        updatePreview('role', this.options[this.selectedIndex].text);
    });


    // Password validation
    passwordInput.addEventListener('input', validatePasswordMatch);
    passwordConfirmationInput.addEventListener('input', validatePasswordMatch);

    function updateAvatarPreview(name) {
        if (name && name.trim()) {
            const initials = getInitials(name);
            avatarPreview.textContent = initials;
            avatarPreview.style.backgroundColor = generateColorFromName(name);
        }
    }

    function generateColorFromName(name) {
        let hash = 0;
        for (let i = 0; i < name.length; i++) {
            hash = name.charCodeAt(i) + ((hash << 5) - hash);
        }
        const hue = hash % 360;
        return `hsl(${hue}, 70%, 60%)`;
    }

    function updatePreview(field, newValue) {
        const oldElement = document.getElementById(`old${field.charAt(0).toUpperCase() + field.slice(1)}`);
        const newElement = document.getElementById(`new${field.charAt(0).toUpperCase() + field.slice(1)}`);
        
        if (newValue !== originalValues[field]) {
            oldElement.textContent = originalValues[field];
            newElement.textContent = newValue;
            newElement.parentElement.classList.add('changed');
            setTimeout(() => {
                newElement.parentElement.classList.remove('changed');
            }, 600);
        } else {
            oldElement.textContent = '';
            newElement.textContent = originalValues[field];
        }
    }

    function validatePasswordMatch() {
        const password = passwordInput.value;
        const confirmation = passwordConfirmationInput.value;

        if (password && confirmation && password !== confirmation) {
            passwordConfirmationInput.classList.add('is-invalid');
            passwordConfirmationInput.classList.remove('is-valid');
        } else if (password && confirmation && password === confirmation) {
            passwordConfirmationInput.classList.remove('is-invalid');
            passwordConfirmationInput.classList.add('is-valid');
        } else {
            passwordConfirmationInput.classList.remove('is-invalid', 'is-valid');
        }
    }

    // Toggle password visibility
    window.togglePasswordVisibility = function(inputId) {
        const input = document.getElementById(inputId);
        const icon = input.parentNode.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fas fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fas fa-eye';
        }
    };

    // Form submission handler
    form.addEventListener('submit', function(e) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Check if there are any changes
        const hasChanges = 
            nameInput.value !== originalValues.name ||
            emailInput.value !== originalValues.email ||
            roleSelect.value !== originalValues.role ||

            passwordInput.value;
        
        if (!hasChanges) {
            e.preventDefault();
            showAlert('Tidak ada perubahan data yang dilakukan.', 'warning');
            return;
        }
        
        if (!validateForm()) {
            e.preventDefault();
            return;
        }
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memperbarui...';
        submitBtn.disabled = true;
        
        // Re-enable after 3 seconds (in case of error)
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 3000);
    });

    function validateForm() {
        let isValid = true;
        
        // Check required fields
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });

        // Validate password match
        if (passwordInput.value && passwordInput.value !== passwordConfirmationInput.value) {
            isValid = false;
            passwordConfirmationInput.classList.add('is-invalid');
            showAlert('Password dan konfirmasi password tidak cocok', 'danger');
        }

        // Validate password strength if provided
        if (passwordInput.value && passwordInput.value.length < 8) {
            isValid = false;
            passwordInput.classList.add('is-invalid');
            showAlert('Password harus minimal 8 karakter', 'warning');
        }

        return isValid;
    }

    function showAlert(message, type) {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.custom-alert');
        existingAlerts.forEach(alert => alert.remove());
        
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} custom-alert alert-dismissible fade show mt-3`;
        alertDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${type === 'warning' ? 'exclamation-triangle' : 'exclamation-circle'} me-2"></i>
                <div>${message}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        form.prepend(alertDiv);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentElement) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // Global reset function
    window.resetForm = function() {
        // Reset form values to original
        nameInput.value = originalValues.name;
        emailInput.value = originalValues.email;
        roleSelect.value = originalValues.role;

        passwordInput.value = '';
        passwordConfirmationInput.value = '';
        
        // Trigger change events to update UI
        nameInput.dispatchEvent(new Event('input'));
        emailInput.dispatchEvent(new Event('input'));
        roleSelect.dispatchEvent(new Event('change'));

        
        // Remove validation styles
        const fields = form.querySelectorAll('.form-control, .form-select');
        fields.forEach(field => {
            field.classList.remove('is-invalid', 'is-valid');
        });
        
        showAlert('Form telah direset ke nilai semula', 'info');
    };

    // Initialize preview with original values
    Object.keys(originalValues).forEach(field => {
        if (field !== 'is_active') {
            updatePreview(field, originalValues[field]);
        }
    });
    updatePreview('status', originalValues.is_active === '1' ? 'Aktif' : 'Non-Aktif');
});
</script>
@endsection