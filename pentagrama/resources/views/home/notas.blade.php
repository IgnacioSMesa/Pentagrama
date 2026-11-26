@extends('layouts.app')

@section('title', 'Notas a pentagrama')

@push('scripts')
    @vite(['resources/js/app.js'])
@endpush

@section('content')

    @auth
        <p>
            Hola, {{ auth()->user()->name }}
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit">Salir</button>
        </form>
        </p>

        <label>Instrumento: <select id="instrument"></select></label>
        <button id="start">Escuchar</button>
        <span id="actual"></span>
        <div id="score"></div>

    @endauth

@endsection
