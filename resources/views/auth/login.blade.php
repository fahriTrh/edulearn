<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EduLearn</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
    <body>

        <body class="bg-gradient-to-br from-indigo-500 via-purple-500 to-purple-600 min-h-screen flex items-center justify-center px-4 relative overflow-hidden">
            <!-- Background Bubbles -->
            <div class="absolute w-[500px] h-[500px] bg-white/10 rounded-full top-[-250px] right-[-100px] animate-[float_6s_ease-in-out_infinite]"></div>
            <div class="absolute w-[400px] h-[400px] bg-white/5 rounded-full bottom-[-200px] left-[-100px] animate-[float_8s_ease-in-out_infinite]"></div>
        
            <!-- Login Container -->
            <div class="bg-white rounded-2xl shadow-2xl p-12 max-w-md w-full relative z-10 animate-[slideUp_0.5s_ease]">
                <!-- Logo Section -->
                <div class="text-center mb-8">
                    <div class="text-4xl mb-2">🎓</div>
                    <h1 class="text-2xl font-bold bg-gradient-to-br from-indigo-500 to-purple-600 bg-clip-text text-transparent mb-2">EduLearn</h1>
                    <p class="text-sm text-gray-500">Platform E-Learning Modern</p>
                </div>
        
                <!-- Header -->
                <div class="text-center mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Selamat Datang! 👋</h2>
                    <p class="text-sm text-gray-600">Silakan login untuk melanjutkan</p>
                </div>
        
                <!-- Error Message -->
                <div id="errorMessage" class="bg-red-100 text-red-600 px-4 py-2 rounded-lg mb-4 hidden border-l-4 border-red-500 text-sm">
                    Email atau password salah!
                </div>
        
                <!-- Form -->
                <form method="POST" action="/login" class="space-y-6">
                    @csrf
        
                    <!-- Identifier -->
                    <div>
                        <label for="emailInput" class="block text-sm font-medium text-gray-700 mb-2">Email atau NIM</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400 text-lg">📧</span>
                            <input type="text" id="emailInput" name="identifier" required
                                class="pl-10 pr-4 py-2 w-full border-2 border-gray-200 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                placeholder="Masukkan email atau NIM">
                        </div>
                    </div>
        
                    <!-- Password -->
                    <div>
                        <label for="passwordInput" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400 text-lg">🔒</span>
                            <input type="password" id="passwordInput" name="password" required
                                class="pl-10 pr-10 py-2 w-full border-2 border-gray-200 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                placeholder="Masukkan password">
                            <span class="absolute right-3 top-2.5 text-gray-400 text-lg cursor-pointer select-none" onclick="togglePassword()">👁️</span>
                        </div>
                    </div>
        
                    <!-- Submit Button -->
                    <button type="submit" id="loginBtn"
                        class="w-full py-3 bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-xl font-semibold text-lg hover:shadow-lg hover:-translate-y-0.5 transition flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed">
                        <span id="btnText">Masuk</span>
                        <span id="loadingSpinner" class="hidden animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
                    </button>
                </form>
            </div>
        
            <!-- Custom Animations -->
            <style>
                @keyframes float {
                    0%, 100% { transform: translateY(0); }
                    50% { transform: translateY(-20px); }
                }
        
                @keyframes slideUp {
                    from { opacity: 0; transform: translateY(30px); }
                    to { opacity: 1; transform: translateY(0); }
                }
        
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    25% { transform: translateX(-10px); }
                    75% { transform: translateX(10px); }
                }
            </style>


<script>
    // Toggle visibility of password input
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

    // Show error message (optional, if Laravel returns error via Blade)
    function showError(message = 'Email atau password salah!') {
        const errorMessage = document.getElementById('errorMessage');
        errorMessage.textContent = message;
        errorMessage.classList.remove('hidden');
        setTimeout(() => {
            errorMessage.classList.add('hidden');
        }, 5000);
    }

    // Auto-focus on email input
    document.getElementById('emailInput').focus();
</script>

</body>
</html>