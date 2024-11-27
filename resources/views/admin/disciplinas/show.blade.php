@extends('layouts.admin')

@section('content')
    <h1>Detalhes da Disciplina</h1>

    <p><strong>Nome:</strong> {{ $disciplina->nome }}</p>
    <p><strong>Departamento:</strong> {{ $disciplina->departamento->nome }}</p>

    <h2>Docentes que Lecionam Esta Disciplina</h2>
        @if($disciplina->docentes->isEmpty())
        <p>Nenhum docente leciona esta disciplina.</p>
        @else
        <ul>
            @foreach($disciplina->docentes as $docente)
            <li>{{ $docente->nome }}</li>
            @endforeach
        </ul>
@endif


    <a href="{{ route('admin.disciplinas.index') }}">Voltar</a>
    <a href="{{ route('admin.disciplinas.edit', $disciplina->id) }}">Editar</a>

    <form action="{{ route('admin.disciplinas.destroy', $disciplina->id) }}" method="POST" style="display:inline" class="delete-form">
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
