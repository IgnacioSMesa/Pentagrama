@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <x-auth-card>

        <h2 class="text-2xl font-bold text-slate-900">Iniciar sesión</h2>
        <p class="mt-1 text-sm text-slate-500">Bienvenido de nuevo 👋</p>

        @if ($errors->any())
            <div class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
            @csrf

            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                       class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                       placeholder="tu@email.com">
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                       placeholder="••••••••">
            </div>

            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                Recordarme
            </label>

            <button type="submit"
                    class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 font-semibold text-white shadow transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300 active:scale-[.99]">
                Entrar
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-600">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-800 hover:underline">Regístrate</a>
        </p>

    </x-auth-card>
@endsection
