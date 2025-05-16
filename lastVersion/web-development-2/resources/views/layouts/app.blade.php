<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <head>
    <meta name="driver-id" content="{{ auth()->user()->id }}">
</head>
    <title>Delivery App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        @vite(['resources/js/app.js'])
        <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <a class="navbar-brand" href="/">Delivery App</a>
                <a class="navbar-brand" href="/driver/dashboard">Home</a>
                <a href="{{ url('/chatify') }}">
                    <img src="{{ asset('images/chat-icon.png') }}" alt="Chat" style="width: 35px; height: 35px;">
                </a>
            </div>

            <div class="d-flex align-items-center gap-3">
                @auth
                    @php
                        $driver = \App\Models\Driver::where('user_id', auth()->id())->first();
                    @endphp

                    @if ($driver)
                        <form method="POST" action="{{ route('driver.toggleStatus') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $driver->status === 'available' ? 'btn-success' : 'btn-secondary' }}">
                                {{ $driver->status === 'available' ? '🟢 Available' : '⚫ Offline' }}
                            </button>
                        </form>
                    @endif
                  
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
