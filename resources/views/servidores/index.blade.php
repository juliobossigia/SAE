@extends('layout')

@section('content')
    <header>
        <h1>Lista de Servidores</h1>
        <a href="{{ route('servidores.create') }}">Adicionar Servidor</a>
        @livewire('logout-button')
        <br>
    </header>

    @if ($message = Session::get('success'))
        <div>
            {{ $message }}
        </div>
    @endif

    <!-- Formulário de Filtro -->
    <form action="{{ route('servidores.index') }}" method="GET">
        <label for="setor_id">Filtrar por Setor:</label>
        <select name="setor_id" id="setor_id" onchange="this.form.submit()">
            <option value="">Todos</option>
            @foreach($setores as $setor)
                <option value="{{ $setor->id }}" {{ request('setor_id') == $setor->id ? 'selected' : '' }}>{{ $setor->nome }}</option>
            @endforeach
        </select>
    </form>

    <table>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>CPF</th>
            <th>Setor</th>
            <th>Ações</th>
        </tr>
        @foreach ($servidores as $servidor)
            <tr>
                <td>{{ $servidor->nome }}</td>
                <td>{{ $servidor->email }}</td>
                <td>{{ $servidor->cpf }}</td>
                <td>{{ $servidor->setor->nome }}</td>
                <td>
                    <a href="{{ route('servidores.show', $servidor->id) }}">Ver</a>
                    <a href="{{ route('servidores.edit', $servidor->id) }}">Editar</a>
                    <form action="{{ route('servidores.destroy', $servidor->id) }}" method="POST" style="display:inline" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Deletar</button>
                    </form>

                    <script>
                        document.querySelectorAll('.delete-form').forEach(form => {
                        form.addEventListener('submit', function(event) {
                         if (!confirm('Tem certeza que deseja apagar?')) {
                             event.preventDefault();
                            }
                         });
                        });
                    </script>
                </td>
            </tr>
        @endforeach
    </table>
    <div>
        <br>
        <a href="{{ route('dashboard')}}">Voltar</a>
    </div>
    <footer>
        <br>
    </footer>
@endsection
