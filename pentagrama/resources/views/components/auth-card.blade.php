<main class="flex min-h-screen items-center justify-center p-4 sm:p-6">
    <div class="w-full max-w-md">

        {{-- Logo: pentagrama con una nota --}}
        <div class="mb-6 flex flex-col items-center text-white">
            <svg viewBox="0 0 120 50" class="h-12 w-28" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <line x1="0" y1="10" x2="120" y2="10" opacity=".7"/>
                <line x1="0" y1="18" x2="120" y2="18" opacity=".7"/>
                <line x1="0" y1="26" x2="120" y2="26" opacity=".7"/>
                <line x1="0" y1="34" x2="120" y2="34" opacity=".7"/>
                <line x1="0" y1="42" x2="120" y2="42" opacity=".7"/>
                <ellipse cx="60" cy="30" rx="6" ry="4.5" fill="currentColor" transform="rotate(-20 60 30)"/>
                <line x1="65.5" y1="28" x2="65.5" y2="4" stroke-width="2"/>
            </svg>
            <span class="mt-2 text-2xl font-semibold tracking-wide">Pentagrama</span>
        </div>

        {{-- Tarjeta --}}
        <div class="rounded-2xl bg-white p-6 shadow-2xl sm:p-8">
            {{ $slot }}
        </div>

    </div>
</main>
