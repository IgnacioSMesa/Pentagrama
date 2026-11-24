@extends('layouts.app')

@section('title', 'Login')

@section('content')

    <h2>Iniciar sesion</h2>
    @if ($errors -> any())
        <p>{{ $errors -> first() }}</p>
    @endif

    <form method="POST" action = "{{ route('login') }}">
        @csrf
        <label> Email: <input type="email" name="email" value="{{ old('email') }}" required></label><br>
        <label> Contraseña: <input type="password" name="password" required></label><br>
        <label><input type="checkbox" name="remember"> Recordarme</label><br>
        <button type="submit"> Entrar </button>
    </form>

    <p>¿No tienes cuenta? <a href="{{ route('register') }}"> Regístrate </a></p>

@endsection
