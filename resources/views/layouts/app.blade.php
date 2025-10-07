<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $title ?? config('app.name', 'Reciclapp') }}</title>

  {{-- Fuente --}}
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  {{-- Assets (Tailwind + Vite) --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900">
  <div class="min-h-screen bg-gradient-to-b from-brand-50 to-white">
    {{-- Barra superior (puedes seguir usando la de Breeze) --}}
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur border-b">
      @include('layouts.navigation')
    </header>    

    {{-- Contenido principal --}}
    <main>
      {{ $slot }}
    </main>

    {{-- Footer --}}
    
  </div>
</body>
</html>
