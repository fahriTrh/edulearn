<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EduLearn</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -250px;
            right: -100px;
            animation: float 6s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -200px;
            left: -100px;
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 3rem;
            max-width: 450px;
            width: 100%;
            position: relative;
            z-index: 1;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }

        .brand-name {
            font-size: 2rem;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }

        .tagline {
            color: #666;
            font-size: 0.9rem;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h2 {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #666;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: #666;
        }

        .form-group input {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 3rem;
            border: 2px solid #e8ebf0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
            outline: none;
        }

        .form-group input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            font-size: 1.2rem;
            user-select: none;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .checkbox-wrapper input {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .checkbox-wrapper label {
            font-size: 0.9rem;
            color: #666;
            cursor: pointer;
        }

        .forgot-password {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .loading {
            display: none;
        }

        .loading.active {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            background: rgba(255, 71, 87, 0.1);
            color: #ff4757;
            padding: 0.8rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: none;
            border-left: 4px solid #ff4757;
            font-size: 0.9rem;
        }

        .error-message.show {
            display: block;
            animation: shake 0.5s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 2rem;
            }

            .brand-name {
                font-size: 1.5rem;
            }

            .login-header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-section">
            <div class="logo">🎓</div>
            <div class="brand-name">EduLearn</div>
            <div class="tagline">Platform E-Learning Modern</div>
        </div>

        <div class="login-header">
            <h2>Selamat Datang! 👋</h2>
            <p>Silakan login untuk melanjutkan</p>
        </div>

        <div class="error-message" id="errorMessage">
            Email atau password salah!
        </div>

        <form method="POST" action="/login">
            @csrf
            <div class="form-group">
                <label>Email atau NIM</label>
                <div class="input-wrapper">
                    <span class="input-icon">📧</span>
                    <input type="text" id="emailInput" name="identifier" placeholder="Masukkan email atau NIM" required>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <span class="input-icon">🔒</span>
                    <input type="password" id="passwordInput" name="password" placeholder="Masukkan password" required>
                    <span class="password-toggle" onclick="togglePassword()">👁️</span>
                </div>
            </div>

            <button type="submit" class="login-btn" id="loginBtn">
                <span id="btnText">Masuk</span>
                <span class="loading" id="loadingSpinner"></span>
            </button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const toggleIcon = event.target;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = '👁️‍🗨️';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = '👁️';
            }
        }

        function handleLogin(event) {
            event.preventDefault();
            
            const email = document.getElementById('emailInput').value;
            const password = document.getElementById('passwordInput').value;
            const rememberMe = document.getElementById('rememberMe').checked;
            const loginBtn = document.getElementById('loginBtn');
            const btnText = document.getElementById('btnText');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const errorMessage = document.getElementById('errorMessage');

            // Hide error message
            errorMessage.classList.remove('show');

            // Show loading state
            loginBtn.disabled = true;
            btnText.style.display = 'none';
            loadingSpinner.classList.add('active');

            // INTEGRASI DENGAN LARAVEL:
            /*
            fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    email: email,
                    password: password,
                    remember: rememberMe
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(`✅ Login berhasil!`, 'success');
                    window.location.href = data.redirect_url;
                } else {
                    showError(data.message || 'Email atau password salah!');
                    loginBtn.disabled = false;
                    btnText.style.display = 'inline';
                    loadingSpinner.classList.remove('active');
                }
            })
            .catch(error => {
                showError('Terjadi kesalahan, silakan coba lagi');
                loginBtn.disabled = false;
                btnText.style.display = 'inline';
                loadingSpinner.classList.remove('active');
            });
            */

            // Demo - hapus saat integrasi
            setTimeout(() => {
                console.log('Login:', { email, password, rememberMe });
                showNotification(`✅ Login berhasil!`, 'success');
                
                // Reset button
                loginBtn.disabled = false;
                btnText.style.display = 'inline';
                loadingSpinner.classList.remove('active');
            }, 1500);
        }

        function showError(message = 'Email atau password salah!') {
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.textContent = message;
            errorMessage.classList.add('show');
            setTimeout(() => {
                errorMessage.classList.remove('show');
            }, 5000);
        }

        function forgotPassword(event) {
            event.preventDefault();
            showNotification('📧 Link reset password telah dikirim ke email Anda', 'info');
        }

        function goToRegister(event) {
            event.preventDefault();
            showNotification('Mengarahkan ke halaman registrasi...', 'info');
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#2ed573' : type === 'error' ? '#ff4757' : '#667eea'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.3);
                z-index: 3000;
                animation: slideIn 0.3s ease;
            `;
            notification.textContent = message;
            
            const style = document.createElement('style');
            style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(400px); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
            `;
            if (!document.querySelector('style[data-notification]')) {
                style.setAttribute('data-notification', 'true');
                document.head.appendChild(style);
            }
            
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.style.animation = 'slideIn 0.3s ease reverse';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Auto-focus
        document.getElementById('emailInput').focus();
    </script>
</body>
</html>