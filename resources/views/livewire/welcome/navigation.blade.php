<nav class="-mx-3 flex flex-1 justify-end">
    @auth
        @php
            $dashboardRoute = match(auth()->user()->role) {
                'admin' => route('admin.dashboard'),
                'servidor' => route('servidor.dashboard'),
                'docente' => route('docente.dashboard'),
                'responsavel' => route('responsavel.dashboard'),
                default => route('dashboard'),
            };
        @endphp
        <a
            href="{{ $dashboardRoute }}"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
        >
            Dashboard
        </a>
    @else
        <a
            href="{{ route('login') }}"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
        >
            Entrar
        </a>

        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                Registre-se
            </a>
        @endif
    @endauth
</nav>
