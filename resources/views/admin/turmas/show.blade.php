@extends('layout')

@section('content')
    <h1>Detalhes do Turma</h1>

    <p><strong>Letra:</strong> {{ $turma->letra }}</p>
    <p><strong>Ano:</strong> {{ $turma->ano }}</p>

    <h2>Alunos na Turma</h2>
    @if($turma->alunos->isEmpty())
        <p>Não há alunos nesta turma.</p>
    @else
    <table>
        <tr>
            <th>Nome</th>
            <th>Matricula</th>
        </tr>
            @foreach($turma->alunos as $aluno)
            <tr>
                <td>{{ $aluno->nome }}</td>  
                <td>{{ $aluno->matricula }}</td>
                <td><a href="{{ route('admin.alunos.show', $aluno->id) }}">Ver</a></td>
            </tr>
            @endforeach
        
    @endif
    </table>
    <br>
    <a href="{{ route('admin.turmas.index') }}">Voltar</a>
    <a href="{{ route('admin.turmas.edit', $turma->id) }}">Editar</a>

    <form action="{{ route('admin.turmas.destroy', $turma->id) }}" method="POST" style="display:inline" class="delete-form">
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
