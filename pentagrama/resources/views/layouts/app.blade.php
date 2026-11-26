<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Pentagrama')</title>
    @vite(['resources/css/app.css'])
    @stack('scripts')
</head>
<body @guest class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-violet-900 font-sans text-slate-800 antialiased" @endguest>
    @yield('content')
</body>
</html>
