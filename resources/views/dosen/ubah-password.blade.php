@extends('dosen.app')

@section('content')
<div class="password-container">
    <div class="password-card">
        <div class="card-header-custom">
            <div>
                <h2 class="card-title-custom">🔒 Ubah Password</h2>
                <p class="card-subtitle">Pastikan akun Anda tetap aman dengan password yang kuat</p>
            </div>
        </div>

        @if (session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✅</span>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-error">
            <span class="alert-icon">❌</span>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-error">
            <span class="alert-icon">❌</span>
            <div>
                <strong>Terdapat kesalahan:</strong>
                <ul style="margin: 0.5rem 0 0 1.5rem;">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <form action="/ubah-password" method="POST">
            @csrf

            <div class="form-group">
                <label for="current_password">
                    Password Saat Ini <span class="required">*</span>
                </label>
                <div class="password-input-wrapper">
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        required
                        placeholder="Masukkan password saat ini">
                    <button type="button" class="toggle-password" onclick="togglePassword('current_password')">
                        👁️
                    </button>
                </div>
                <p style="color: #c0392b; margin-top: 10px;">
                    @error('current_password')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="form-group">
                <label for="new_password">
                    Password Baru <span class="required">*</span>
                </label>
                <div class="password-input-wrapper">
                    <input
                        type="password"
                        id="new_password"
                        name="new_password"
                        required
                        placeholder="Masukkan password baru"
                        oninput="checkPasswordStrength(this.value)">
                    <button type="button" class="toggle-password" onclick="togglePassword('new_password')">
                        👁️
                    </button>
                </div>
                <p style="color: #c0392b; margin-top: 10px;">
                    @error('new_password')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="form-group">
                <label for="new_password_confirmation">
                    Konfirmasi Password Baru <span class="required">*</span>
                </label>
                <div class="password-input-wrapper">
                    <input
                        type="password"
                        id="new_password_confirmation"
                        name="new_password_confirmation"
                        required
                        placeholder="Masukkan ulang password baru">
                    <button type="button" class="toggle-password" onclick="togglePassword('new_password_confirmation')">
                        👁️
                    </button>
                </div>
                <p style="color: #c0392b; margin-top: 10px;">
                    @error('new_password_confirmation')
                    {{ $message }}
                    @enderror
                </p>
                <div class="password-match" id="passwordMatch"></div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="window.history.back()">
                    Batal
                </button>
                <button type="submit" class="btn-primary">
                    <span>💾</span>
                    <span>Simpan Password</span>
                </button>
            </div>
        </form>
    </div>

    <div class="tips-card">
        <h3 class="tips-title">💡 Tips Password Aman</h3>
        <ul class="tips-list">
            <li>Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol</li>
            <li>Minimal 8 karakter, lebih panjang lebih baik</li>
            <li>Hindari menggunakan informasi pribadi (nama, tanggal lahir)</li>
            <li>Jangan gunakan password yang sama untuk akun berbeda</li>
            <li>Ubah password secara berkala</li>
            <li>Jangan bagikan password kepada siapa pun</li>
        </ul>
    </div>
</div>

<style>
    .password-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }

    .password-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 2rem;
    }

    .card-header-custom {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #f5f7fa;
    }

    .card-title-custom {
        font-size: 1.8rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .card-subtitle {
        color: #666;
        font-size: 0.95rem;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 0.8rem;
    }

    .alert-success {
        background: rgba(46, 213, 115, 0.1);
        border: 1px solid rgba(46, 213, 115, 0.3);
        color: #27ae60;
    }

    .alert-error {
        background: rgba(235, 87, 87, 0.1);
        border: 1px solid rgba(235, 87, 87, 0.3);
        color: #c0392b;
    }

    .alert-icon {
        font-size: 1.2rem;
    }

    .required {
        color: #e74c3c;
    }

    .password-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .password-input-wrapper input {
        flex: 1;
        padding-right: 3rem;
    }

    .toggle-password {
        position: absolute;
        right: 0.8rem;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.2rem;
        padding: 0.5rem;
        opacity: 0.6;
        transition: opacity 0.3s;
    }

    .toggle-password:hover {
        opacity: 1;
    }

    .password-strength {
        margin-top: 0.8rem;
    }

    .strength-bar {
        height: 6px;
        background: #e8ebf0;
        border-radius: 3px;
        overflow: hidden;
        margin-bottom: 0.5rem;
    }

    .strength-fill {
        height: 100%;
        width: 0%;
        transition: all 0.3s;
        border-radius: 3px;
    }

    .strength-text {
        font-size: 0.85rem;
        font-weight: 600;
    }

    .password-requirements {
        margin-top: 1rem;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.5rem;
    }

    .requirement {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: #666;
    }

    .requirement.met {
        color: #27ae60;
    }

    .req-icon {
        font-size: 1rem;
    }

    .requirement.met .req-icon::before {
        content: '✅';
    }

    .password-match {
        margin-top: 0.5rem;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .password-match.match {
        color: #27ae60;
    }

    .password-match.no-match {
        color: #e74c3c;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 2px solid #f5f7fa;
    }

    .btn-secondary {
        flex: 1;
        padding: 0.8rem 1.5rem;
        background: #f5f7fa;
        color: #666;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-secondary:hover {
        background: #e8ebf0;
    }

    .tips-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        padding: 2rem;
        height: fit-content;
        position: sticky;
        top: 2rem;
    }

    .tips-title {
        font-size: 1.3rem;
        margin-bottom: 1.5rem;
    }

    .tips-list {
        list-style: none;
        padding: 0;
    }

    .tips-list li {
        padding: 0.8rem 0;
        padding-left: 1.5rem;
        position: relative;
        line-height: 1.6;
    }

    .tips-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        font-weight: bold;
    }

    @media (max-width: 968px) {
        .password-container {
            grid-template-columns: 1fr;
        }

        .tips-card {
            position: static;
        }

        .password-requirements {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const button = input.nextElementSibling;

        if (input.type === 'password') {
            input.type = 'text';
            button.textContent = '👁️‍🗨️';
        } else {
            input.type = 'password';
            button.textContent = '👁️';
        }
    }

    function checkPasswordStrength(password) {
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');

        // Check requirements
        const requirements = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password)
        };

        // Update requirement indicators
        document.getElementById('req-length').classList.toggle('met', requirements.length);
        document.getElementById('req-uppercase').classList.toggle('met', requirements.uppercase);
        document.getElementById('req-lowercase').classList.toggle('met', requirements.lowercase);
        document.getElementById('req-number').classList.toggle('met', requirements.number);

        // Calculate strength
        const metCount = Object.values(requirements).filter(Boolean).length;
        let strength = 0;
        let strengthLabel = '';
        let strengthColor = '';

        if (metCount === 0) {
            strength = 0;
            strengthLabel = 'Kekuatan password';
            strengthColor = '#e8ebf0';
        } else if (metCount === 1) {
            strength = 25;
            strengthLabel = 'Lemah';
            strengthColor = '#e74c3c';
        } else if (metCount === 2) {
            strength = 50;
            strengthLabel = 'Cukup';
            strengthColor = '#f39c12';
        } else if (metCount === 3) {
            strength = 75;
            strengthLabel = 'Baik';
            strengthColor = '#3498db';
        } else {
            strength = 100;
            strengthLabel = 'Sangat Kuat';
            strengthColor = '#27ae60';
        }

        strengthFill.style.width = strength + '%';
        strengthFill.style.backgroundColor = strengthColor;
        strengthText.textContent = strengthLabel;
        strengthText.style.color = strengthColor;

        // Check password confirmation match
        checkPasswordMatch();
    }

    function checkPasswordMatch() {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('new_password_confirmation').value;
        const matchElement = document.getElementById('passwordMatch');

        if (confirmPassword.length === 0) {
            matchElement.textContent = '';
            matchElement.className = 'password-match';
            return;
        }

        if (newPassword === confirmPassword) {
            matchElement.textContent = '✓ Password cocok';
            matchElement.className = 'password-match match';
        } else {
            matchElement.textContent = '✗ Password tidak cocok';
            matchElement.className = 'password-match no-match';
        }
    }

    // Add event listener for password confirmation
    document.getElementById('new_password_confirmation').addEventListener('input', checkPasswordMatch);

    // Form validation
    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('new_password_confirmation').value;

        if (newPassword !== confirmPassword) {
            e.preventDefault();
            alert('Password baru dan konfirmasi password tidak cocok!');
            return false;
        }

        // Check if password meets requirements
        const requirements = {
            length: newPassword.length >= 8,
            uppercase: /[A-Z]/.test(newPassword),
            lowercase: /[a-z]/.test(newPassword),
            number: /[0-9]/.test(newPassword)
        };

        const allMet = Object.values(requirements).every(Boolean);

        if (!allMet) {
            e.preventDefault();
            alert('Password baru harus memenuhi semua persyaratan!');
            return false;
        }
    });
</script>
@endsection