<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title') Personal Tools</title>
  @vite('resources/css/app.css')
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="font-sans bg-background leading-normal tracking-normal text-text">
  <x-navbar />
  <x-breadcrumb/>
  <main class="min-h-svh">
    @yield('content')
  </main>

  <x-footer/>
  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
