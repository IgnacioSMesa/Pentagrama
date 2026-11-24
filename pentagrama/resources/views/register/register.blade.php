@extends('layouts.app')

@section('title', 'Registro')

@section('content')
    <h1>Crear cuenta</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label>Nombre: <input type="text" name="name" value="{{ old('name') }}" required></label><br>
        <label>Apellido: <input type="text" name="lastname" value="{{ old('lastname') }}" required></label><br>
        <label>Email: <input type="email" name="email" value="{{ old('email') }}" required></label><br>
        <label>Contraseña: <input type="password" name="password" required></label><br>
        <label>Repetir contraseña: <input type="password" name="password_confirmation" required></label><br>
        <button type="submit">Registrarme</button>
    </form>

    <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
@endsection
