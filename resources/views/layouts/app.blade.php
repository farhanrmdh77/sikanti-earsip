<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @if(session('success'))
<style>
    .custom-toast-container {
        position: fixed;
        top: 30px;
        right: -400px; /* Sembunyi di luar layar kanan */
        background-color: #ffffff;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        width: 380px;
        z-index: 99999; /* Pastikan selalu di atas navbar & sidebar */
        transition: right 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        overflow: hidden;
    }
    
    .custom-toast-container.show {
        right: 30px; /* Meluncur masuk */
    }

    .toast-icon-circle {
        width: 50px;
        height: 50px;
        background-color: #10b981; /* Warna hijau emerald sukses */
        color: white;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.3rem;
        flex-shrink: 0;
        margin-right: 18px;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
    }

    .toast-text-area h4 {
        font-size: 1rem;
        font-weight: 800;
        color: #1f2937;
        margin: 0 0 4px 0;
        letter-spacing: 0.5px;
    }

    .toast-text-area p {
        font-size: 0.85rem;
        color: #6b7280;
        margin: 0;
        line-height: 1.4;
    }

    .toast-btn-close {
        position: absolute;
        top: 15px;
        right: 15px;
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        font-size: 1rem;
        transition: 0.2s;
    }

    .toast-btn-close:hover { color: #4b5563; }

    /* Animasi Garis Bawah (Progress Bar) */
    .toast-progress-bar {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 4px;
        background-color: #10b981;
        width: 100%;
        animation: toastProgress 3s linear forwards;
    }

    @keyframes toastProgress {
        100% { width: 0; }
    }
</style>

<div id="elegantToast" class="custom-toast-container">
    <div class="toast-icon-circle">
        <i class="fa-solid fa-check"></i>
    </div>
    <div class="toast-text-area">
        <h4>SUKSES!</h4>
        <p>{{ session('success') }}</p>
    </div>
    <button class="toast-btn-close" onclick="forceCloseToast()"><i class="fa-solid fa-xmark"></i></button>
    <div class="toast-progress-bar"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toast = document.getElementById('elegantToast');
        
        // Beri jeda sedikit sebelum meluncur masuk agar animasinya terlihat halus
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);

        // Otomatis hilang setelah 3 detik (3000 ms)
        setTimeout(() => {
            forceCloseToast();
        }, 3000);
    });

    function forceCloseToast() {
        const toast = document.getElementById('elegantToast');
        if(toast) {
            toast.classList.remove('show'); // Meluncur keluar
            setTimeout(() => { toast.remove(); }, 500); // Hapus elemen dari HTML setelah animasi selesai
        }
    }
</script>
@endif
</body>
</html>
