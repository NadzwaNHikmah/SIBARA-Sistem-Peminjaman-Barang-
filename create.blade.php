@extends('layouts.app')

@section('content')
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col">
            <h1 class="page-title">Tambah Pengguna Baru</h1>
            <p class="page-subtitle">Buat akun pengguna baru untuk akses sistem</p>
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
                    <i class="fas fa-user-plus me-2 text-primary"></i>
                    Form Tambah Pengguna
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST" id="userForm">
                    @csrf

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
                                               value="{{ old('name') }}"
                                               id="nameInput">
                                    </div>
                                    <div class="form-text text-muted">
                                        <small>Gunakan nama lengkap yang jelas dan mudah dikenali</small>
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
                                               value="{{ old('email') }}"
                                               id="emailInput">
                                    </div>
                                    <div class="form-text text-muted">
                                        <small>Email akan digunakan untuk login ke sistem</small>
                                    </div>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Keamanan -->
                            <div class="form-section mb-4">
                                <div class="section-header mb-3">
                                    <h6 class="section-title">
                                        <i class="fas fa-shield-alt me-2 text-warning"></i>
                                        Keamanan
                                    </h6>
                                    <div class="section-badge">Wajib</div>
                                </div>
                                
                                <div class="form-group mb-4">
                                    <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" name="password" class="form-control" 
                                               placeholder="Buat password yang kuat" required
                                               id="passwordInput"
                                               minlength="8">
                                        <button type="button" class="btn btn-outline-secondary" 
                                                onclick="togglePasswordVisibility('passwordInput')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text text-muted">
                                        <small>Minimal 8 karakter, kombinasi huruf dan angka</small>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" name="password_confirmation" class="form-control" 
                                               placeholder="Ulangi password yang sama" required
                                               id="passwordConfirmationInput">
                                        <button type="button" class="btn btn-outline-secondary" 
                                                onclick="togglePasswordVisibility('passwordConfirmationInput')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text text-muted">
                                        <small>Pastikan password sama dengan di atas</small>
                                    </div>
                                </div>

                                <div class="password-strength mt-3">
                                    <div class="progress mb-2" style="height: 6px;">
                                        <div class="progress-bar" id="passwordStrengthBar" 
                                             role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <small class="text-muted" id="passwordStrengthText">Kekuatan password: sangat lemah</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Role & Status -->
                            <div class="form-section mb-4">
                                <div class="section-header mb-3">
                                    <h6 class="section-title">
                                        <i class="fas fa-cog me-2 text-success"></i>
                                        Pengaturan
                                    </h6>
                                    <div class="section-badge">Opsional</div>
                                </div>
                                
                                <div class="form-group mb-4">
                                    <label class="form-label fw-semibold">Role Pengguna</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user-tag"></i>
                                        </span>
                                        <select name="role" class="form-select">
                                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                                Admin
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-text text-muted">
                                        <small>Pilih hak akses untuk pengguna</small>
                                    </div>
                                    @error('role')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Preview Card -->
                            <div class="preview-card">
                                <div class="preview-header">
                                    <i class="fas fa-eye me-2"></i>
                                    Preview Pengguna
                                </div>
                                <div class="preview-body">
                                    <div class="preview-avatar text-center mb-3">
                                        <div class="avatar-lg mx-auto">
                                            <div class="avatar-initials bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                                 style="width: 80px; height: 80px; font-size: 24px; font-weight: 600;"
                                                 id="avatarPreview">
                                                ??
                                            </div>
                                        </div>
                                    </div>
                                    <div class="preview-item">
                                        <small class="text-muted">Nama:</small>
                                        <div class="fw-semibold" id="previewName">-</div>
                                    </div>
                                    <div class="preview-item">
                                        <small class="text-muted">Email:</small>
                                        <div class="fw-semibold" id="previewEmail">-</div>
                                    </div>
                                    <div class="preview-item">
                                        <small class="text-muted">Role:</small>
                                        <div class="fw-semibold" id="previewRole">Admin</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Info Card -->
                            <div class="info-card mt-4">
                                <div class="info-card-header">
                                    <i class="fas fa-lightbulb me-2"></i>
                                    Tips Keamanan
                                </div>
                                <div class="info-card-body">
                                    <div class="info-item">
                                        <i class="fas fa-check-circle text-success"></i>
                                        <span>Gunakan password yang unik</span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-check-circle text-success"></i>
                                        <span>Kombinasikan huruf dan angka</span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-check-circle text-success"></i>
                                        <span>Hindari informasi personal</span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-check-circle text-success"></i>
                                        <span>Minimal 8 karakter</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>
                            Simpan Pengguna
                        </button>
                        <button type="reset" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-undo me-2"></i>
                            Reset Form
                        </button>
                    </div>
                </form>
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

.card-header {
    background: white;
    border-bottom: 1px solid #e3e6f0;
    padding: 25px 30px;
    border-radius: 16px 16px 0 0 !important;
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
    background: #8b5cf6;
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
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
}

.form-text {
    font-size: 0.8rem;
}

/* Password Strength */
.password-strength {
    padding: 15px;
    background: #f8fafc;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.progress {
    border-radius: 4px;
    background: #e5e7eb;
}

.progress-bar {
    transition: all 0.3s ease;
    border-radius: 4px;
}

/* Preview Card */
.preview-card {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
}

.preview-header {
    background: #8b5cf6;
    color: white;
    padding: 12px 16px;
    font-weight: 600;
    font-size: 14px;
}

.preview-body {
    padding: 20px;
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

.avatar-lg {
    margin-bottom: 15px;
}

/* Info Card */
.info-card {
    background: #f0f9ff;
    border: 1px solid #bae6fd;
    border-radius: 12px;
    overflow: hidden;
}

.info-card-header {
    background: #0ea5e9;
    color: white;
    padding: 12px 16px;
    font-weight: 600;
    font-size: 14px;
}

.info-card-body {
    padding: 16px;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
    font-size: 13px;
    color: #475569;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-item i {
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

.btn-primary {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    border: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
}

.btn-outline-secondary:hover {
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
    
    .preview-card, .info-card {
        margin-top: 20px;
    }
}

/* Animation for preview updates */
.preview-item div {
    transition: all 0.3s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('userForm');
    const nameInput = document.getElementById('nameInput');
    const emailInput = document.getElementById('emailInput');
    const passwordInput = document.getElementById('passwordInput');
    const passwordConfirmationInput = document.getElementById('passwordConfirmationInput');
    const roleSelect = document.querySelector('select[name="role"]');

    
    const avatarPreview = document.getElementById('avatarPreview');
    const previewName = document.getElementById('previewName');
    const previewEmail = document.getElementById('previewEmail');
    const previewRole = document.getElementById('previewRole');

    
    const passwordStrengthBar = document.getElementById('passwordStrengthBar');
    const passwordStrengthText = document.getElementById('passwordStrengthText');

    // Real-time preview update
    nameInput.addEventListener('input', function() {
        updateAvatarPreview(this.value);
        previewName.textContent = this.value || '-';
    });

    emailInput.addEventListener('input', function() {
        previewEmail.textContent = this.value || '-';
    });

    roleSelect.addEventListener('change', function() {
        previewRole.textContent = this.options[this.selectedIndex].text;
    });

    // Password strength checker
    passwordInput.addEventListener('input', function() {
        checkPasswordStrength(this.value);
        validatePasswordMatch();
    });

    passwordConfirmationInput.addEventListener('input', validatePasswordMatch);

    function updateAvatarPreview(name) {
        if (name && name.trim()) {
            const initials = getInitials(name);
            avatarPreview.textContent = initials;
            avatarPreview.style.backgroundColor = generateColorFromName(name);
        } else {
            avatarPreview.textContent = '??';
            avatarPreview.style.backgroundColor = '#8b5cf6';
        }
    }

    function getInitials(name) {
        if (!name) return '??';
        return name.split(' ')
            .map(part => part.charAt(0))
            .join('')
            .toUpperCase()
            .substring(0, 2);
    }

    function generateColorFromName(name) {
        let hash = 0;
        for (let i = 0; i < name.length; i++) {
            hash = name.charCodeAt(i) + ((hash << 5) - hash);
        }
        const hue = hash % 360;
        return `hsl(${hue}, 70%, 60%)`;
    }

    function checkPasswordStrength(password) {
        let strength = 0;
        let text = '';

        if (password.length >= 8) strength += 25;
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 25;
        if (password.match(/\d/)) strength += 25;
        if (password.match(/[^a-zA-Z\d]/)) strength += 25;

        passwordStrengthBar.style.width = strength + '%';

        if (strength === 0) {
            text = 'Sangat lemah';
            passwordStrengthBar.className = 'progress-bar bg-danger';
        } else if (strength <= 25) {
            text = 'Lemah';
            passwordStrengthBar.className = 'progress-bar bg-danger';
        } else if (strength <= 50) {
            text = 'Cukup';
            passwordStrengthBar.className = 'progress-bar bg-warning';
        } else if (strength <= 75) {
            text = 'Kuat';
            passwordStrengthBar.className = 'progress-bar bg-info';
        } else {
            text = 'Sangat kuat';
            passwordStrengthBar.className = 'progress-bar bg-success';
        }

        passwordStrengthText.textContent = `Kekuatan password: ${text}`;
    }

    function validatePasswordMatch() {
        const password = passwordInput.value;
        const confirmation = passwordConfirmationInput.value;

        if (confirmation && password !== confirmation) {
            passwordConfirmationInput.classList.add('is-invalid');
            passwordConfirmationInput.classList.remove('is-valid');
        } else if (confirmation && password === confirmation) {
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
        
        if (!validateForm()) {
            e.preventDefault();
            return;
        }
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
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
        if (passwordInput.value !== passwordConfirmationInput.value) {
            isValid = false;
            passwordConfirmationInput.classList.add('is-invalid');
            showAlert('Password dan konfirmasi password tidak cocok', 'danger');
        }

        // Validate password strength
        if (passwordInput.value.length < 8) {
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

    // Initialize preview
    updateAvatarPreview(nameInput.value);
    previewName.textContent = nameInput.value || '-';
    previewEmail.textContent = emailInput.value || '-';
});
</script>
@endsection