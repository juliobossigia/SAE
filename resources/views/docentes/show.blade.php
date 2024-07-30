@extends('layout')

@section('content')
    <h1>Detalhes do Docente</h1>

    <p><strong>Nome:</strong> {{ $docente->nome }}</p>
    <p><strong>Email:</strong> {{ $docente->email }}</p>
    <p><strong>Data de Nascimento:</strong> {{ $docente->data_nascimento }}</p>
    <p><strong>CPF:</strong> {{ $docente->cpf }}</p>
    

    <a href="{{ route('docentes.index') }}">Voltar</a>
    <a href="{{ route('docentes.edit', $docente->id) }}">Editar</a>

    <form action="{{ route('docentes.destroy', $docente->id) }}" method="POST" style="display:inline" class="delete-form">
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
