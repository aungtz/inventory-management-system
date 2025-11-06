<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory System</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .input-field {
            transition: all 0.3s ease;
        }

        .input-field:focus {
            transform: translateY(-2px);
        }

        .login-card {
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-[#1E293B] to-slate-800 flex items-center justify-center p-4">
    <!-- Login Card -->
    <div class="login-card w-full max-w-md bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl overflow-hidden border border-white/20">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-[#1E293B] to-[#0EA5E9] p-6 text-center">
            <div class="flex items-center justify-center space-x-3">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-[#0EA5E9]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Inventory System</h1>
            </div>
            <p class="text-blue-100 mt-2 text-sm">Sign in to access your dashboard</p>
        </div>

        <!-- Form Section -->
        <div class="p-8">
            @error('email')
            <div class="text-red-500">{{ $message }}</div>
            @enderror

            <form method="POST" action="{{route('login.submit')}}">
                <!-- Email Field -->
                @csrf
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <div class="relative">



                        <input
                            id="email"
                            type="email"
                            class="input-field w-full px-4 py-3 pl-11 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#0EA5E9] focus:border-transparent transition-all duration-300"
                            placeholder="Enter your email" name="email">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Password Field -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input
                            id="password"
                            type="password"
                            class="input-field w-full px-4 py-3 pl-11 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#0EA5E9] focus:border-transparent transition-all duration-300"
                            placeholder="Enter your password"
                            name="password">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input
                            id="remember"
                            type="checkbox"
                            class="h-4 w-4 text-[#0EA5E9] focus:ring-[#0EA5E9] border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                    </div>

                    <a href="#" class="text-sm text-[#0EA5E9] hover:text-[#1E293B] transition-colors duration-300 font-medium">
                        Forgot password?
                    </a>
                </div>

                <!-- Login Button -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-[#1E293B] to-[#0EA5E9] text-white py-3 px-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300 hover:from-[#0EA5E9] hover:to-[#1E293B]">
                    Sign In
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="border-t border-gray-200 bg-gray-50/50 px-8 py-4">
            <p class="text-center text-xs text-gray-500">
                &copy; 2025 Inventory System By ATZ. All rights reserved.
            </p>
        </div>
    </div>

    <!-- Demo Script for UI Interactions -->
    <script>
        // Add floating label effect
        document.querySelectorAll('.input-field').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.querySelector('svg').classList.add('text-[#0EA5E9]');
            });

            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.querySelector('svg').classList.remove('text-[#0EA5E9]');
                }
            });
        });

        // Demo login button click
        document.querySelector('button[type="button"]').addEventListener('click', function() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (!email || !password) {
                alert('Please fill in both email and password fields.');
                return;
            }

            // Simulate loading
            this.innerHTML = 'Signing in...';
            this.disabled = true;

            setTimeout(() => {
                alert('Login functionality would be implemented here with backend integration.');
                this.innerHTML = 'Sign In';
                this.disabled = false;
            }, 1500);
        });
    </script>
</body>

</html>