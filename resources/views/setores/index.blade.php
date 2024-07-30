@extends('layout')

@section('content')
    <h1>Lista de Setores</h1>

    <a href="{{ route('setores.create') }}">Adicionar Setor</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
        @foreach ($setores as $setor)
            <tr>
                <td>{{ $setor->id }}</td>
                <td>{{ $setor->nome }}</td>
                <td>
                    <a href="{{ route('setores.show', $setor->id) }}">Ver</a>
                    <a href="{{ route('setores.edit', $setor->id) }}">Editar</a>
                    <form action="{{ route('setores.destroy', $setor->id) }}" method="POST" style="display:inline"class="delete-form">
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

    <br>
    <a href="{{ route('dashboard') }}">Voltar</a>
@endsection
