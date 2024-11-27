@extends('layouts.admin')

@section('content')
    <h1>Detalhes do Setor</h1>

    <p><strong>ID:</strong> {{ $setor->id }}</p>
    <p><strong>Nome:</strong> {{ $setor->nome }}</p>

    <h2>Servidores do Setor</h2>
    @if($setor->servidores->isEmpty())
        <p>Não há servidores nesse setor.</p>
    @else
    <table>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
        </tr>
            @foreach($setor->servidores as $servidor)
            <tr>
                <td>{{ $servidor->nome }}</td>  
                <td>{{ $servidor->cpf }}</td>
                <td><a href="{{ route('servidores.show', $servidor->id) }}">Ver</a></td>
            </tr>
            @endforeach
        
    @endif
    </table>
    <br>

    <a href="{{ route('admin.setores.index') }}">Voltar</a>
    <a href="{{ route('admin.setores.edit', $setor->id) }}">Editar</a>

    <form action="{{ route('admin.setores.destroy', $setor->id) }}" method="POST" style="display:inline" class="delete-form">
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
@endsection
