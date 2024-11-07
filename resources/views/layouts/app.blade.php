<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>SAE - Sistema de Acompanhamento Educacional</title>
    <link rel="icon" href="{{ asset('assets/img/SAE e Logo (1).png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @yield('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    @yield('scripts')
</head>
<body>
    <header class="header">
        <div class="container-Nav">
            <div class="logo">
                <img src="{{ asset('assets/img/logo_horizontal_ifsudestemg(2).png') }}" alt="Logo" class="logo">
            </div>
            <div class="profile">
                <i class="fas fa-user-circle"></i>
                <span>{{ Auth::user()->name }}</span>
            </div>
        </div>
    </header>

    <nav class="sidebar">
        <div class="sidebar-user">
            <i class="fas fa-user-circle imagemPerfil"></i>
            <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
            <div class="sidebar-user-position">{{ Auth::user()->role }}</div>
        </div>
        <ul>
            <li><a href="{{ route('alunos.index') }}"><i class="fas fa-user-graduate"></i> Alunos</a></li>
            <li><a href="{{ route('turmas.index') }}"><i class="fas fa-users"></i> <span>Turmas</span></a></li>
            <li><a href="{{ route('cursos.index') }}"><i class="fas fa-graduation-cap"></i> <span>Cursos</span></a></li>
            <li><a href="{{ route('docentes.index') }}"><i class="fas fa-chalkboard-teacher"></i> <span>Docentes</span></a></li>
            <li><a href="{{ route('servidores.index') }}"><i class="fas fa-address-card"></i><span> Servidores</span></a></li>
            <li><a href="{{ route('responsaveis.index') }}"><i class="fas fa-address-book"></i><span> Responsáveis</span></a></li>
            <li><a href="{{ route('registros.index') }}"><i class="fas fa-pen"></i> <span>Registros</span></a></li>
            <li><a href="{{ route('agendamentos.index') }}"><i class='fas fa-clock'></i><span> Agendamentos </span></a></li>
            <li><a href="{{ route('cadastroServidor.create') }}"><i class="fas fa-book"></i> <span>Cadastro Servidor</span></a></li>
            <li><a href="{{ route('cadastroResponsavel.create') }}"><i class="fas fa-book"></i> <span>Cadastro Responsável</span></a></li>
        </ul>
    </nav>

    <main class="content">
        @yield('content')
    </main>

    @include('partials.modals')

    <script>
        // Scripts comuns
    </script>
    @yield('additional-scripts')
</body>
</html>
