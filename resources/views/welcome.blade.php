<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ENSAT - Student Management</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-50 text-gray-900 font-sans">
        <div class="min-h-screen flex flex-col relative overflow-hidden">
            
            <!-- Navbar -->
            <nav class="w-full py-6 px-4 sm:px-6 lg:px-8 z-20">
                <div class="max-w-7xl mx-auto flex justify-between items-center">
                    <!-- Logo -->
                    <div class="flex items-center">
                         <img src="{{ asset('ENSALOGO.png') }}" alt="ENSAT Logo" class="h-20 w-auto">
                    </div>

                    <!-- Auth Buttons -->
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-indigo-600 font-medium transition">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}" class="inline-block">
                                    @csrf
                                    <button type="submit" class="text-gray-700 hover:text-red-600 font-medium transition ml-4">
                                        Log Out
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="px-6 py-2 rounded-full border border-indigo-200 text-indigo-700 font-semibold hover:bg-indigo-50 transition">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-6 py-2 rounded-full bg-indigo-600 text-white font-semibold hover:bg-indigo-700 shadow-md transition">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </nav>

            <!-- Hero Section -->
            <main class="flex-grow flex items-center justify-center relative z-10 px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl w-full mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    
                    <!-- Text Content -->
                    <div class="text-center lg:text-left space-y-6">
                        <p class="text-indigo-600 font-semibold tracking-wide uppercase text-sm">Let's Begin</p>
                        <h1 class="text-5xl sm:text-6xl font-extrabold text-gray-900 leading-tight">
                            Welcome to <br>
                            <span class="text-indigo-700">ENSAT</span>
                        </h1>
                        <p class="text-lg text-gray-600 max-w-lg mx-auto lg:mx-0">
                            Manage student profiles, academic records, and administration effortlessly with our comprehensive platform.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-3 bg-indigo-600 text-white rounded-lg font-semibold shadow-lg hover:bg-indigo-700 hover:shadow-xl transition transform hover:-translate-y-0.5 text-center">
                                    Register
                                </a>
                            @endif
                            <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-3 bg-white text-gray-800 border border-gray-300 rounded-lg font-semibold hover:bg-gray-50 hover:border-gray-400 transition text-center">
                                Log in
                            </a>
                        </div>
                    </div>

                    <!-- Hero Image / Graphic -->
                    <div class="relative hidden lg:block">
                        <!-- Abstract Background Blobs -->
                        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
                        <div class="absolute top-0 right-40 w-72 h-72 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
                        <div class="absolute -bottom-8 right-20 w-80 h-80 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>

                        <!-- Main Illustration Container -->
                        <div class="relative z-10 bg-white bg-opacity-40 backdrop-filter backdrop-blur-sm rounded-3xl p-4 border border-white/50 shadow-2xl transform rotate-2 hover:rotate-0 transition duration-500">
                             <!-- Placeholder for Student Image matching design style -->
                             <div class="relative rounded-2xl overflow-hidden bg-yellow-100 h-[500px] w-full flex items-end justify-center">
                                <div class="absolute inset-0 flex items-center justify-center">
                                     <!-- Decorative Circle similar to design -->
                                     <div class="w-64 h-64 rounded-full bg-yellow-400 opacity-50 absolute top-10 right-10"></div>
                                     <div class="w-20 h-20 rounded-full bg-orange-400 opacity-80 absolute top-4 right-20"></div>
                                     <div class="w-24 h-24 rounded-full bg-indigo-500 opacity-80 absolute top-0 left-0 -ml-4 -mt-4"></div>
                                </div>
                                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" 
                                     alt="Student" 
                                     class="relative z-10 object-cover h-full w-full mix-blend-overlay opacity-90 hover:opacity-100 transition duration-300 rounded-2xl" 
                                     style="mix-blend-mode: normal;">
                             </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Decoration Elements -->
            <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-64 h-64 bg-indigo-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70"></div>
        </div>

        <style>
            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
            .animate-blob {
                animation: blob 7s infinite;
            }
            .animation-delay-2000 {
                animation-delay: 2s;
            }
            .animation-delay-4000 {
                animation-delay: 4s;
            }
        </style>
    </body>
</html>
