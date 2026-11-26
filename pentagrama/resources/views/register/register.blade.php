@extends('layouts.app')

@section('title', 'Registro')

@section('content')
    <x-auth-card>

        <h1 class="text-2xl font-bold text-slate-900">Crear cuenta</h1>
        <p class="mt-1 text-sm text-slate-500">Empieza a convertir tus notas en partitura 🎼</p>

        @if ($errors->any())
            <div class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700" role="alert">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-5">
            @csrf

            {{-- Nombre y apellido: en columnas desde pantallas sm, apilados en móvil --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Nombre</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="given-name"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                </div>
                <div>
                    <label for="lastname" class="mb-1 block text-sm font-medium text-slate-700">Apellido</label>
                    <input id="lastname" type="text" name="lastname" value="{{ old('lastname') }}" required autocomplete="family-name"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                </div>
            </div>

            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                       class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 placeholder-slate-400 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                       placeholder="tu@email.com">
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Contraseña</label>
                <input id="password" type="password" name="password" required minlength="8" autocomplete="new-password"
                       class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                <p class="mt-1 text-xs text-slate-500">Mínimo 8 caracteres.</p>
            </div>

            <div>
                <label for="password_confirmation" class="mb-1 block text-sm font-medium text-slate-700">Repetir contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
            </div>

            <button type="submit"
                    class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 font-semibold text-white shadow transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300 active:scale-[.99]">
                Registrarme
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-600">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-800 hover:underline">Inicia sesión</a>
        </p>

    </x-auth-card>
@endsection
