@extends('layout')

@section('content')
    <h1>Detalhes do Departamento</h1>

    <p><strong>Nome:</strong> {{ $departamento->nome }}</p>

    <!-- Lista de Docentes do Departamento -->
    <h2>Docentes do departamento</h2>
    @if($departamento->docentes->isEmpty())
        <p>Não há docentes cadastrados neste departamento.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departamento->docentes as $docente)
                <tr>
                    <td>{{ $docente->nome }}
                    @if($docente->is_coordenador)
                    <span class="badge bg-primary">Coordenador</span>
                    @endif
                    </td>  
                    <td>{{ $docente->email }}</td>
                    <td><a href="{{ route('docentes.show', $docente->id) }}">Ver Detalhes</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Lista de Disciplinas do Departamento -->
    <h2>Disciplinas do departamento</h2>
    @if($departamento->disciplinas->isEmpty())
        <p>Não há disciplinas cadastradas neste departamento.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departamento->disciplinas as $disciplina)
                <tr>
                    <td>{{ $disciplina->nome }}</td>
                    <td><a href="{{ route('disciplinas.show', $disciplina->id) }}">Ver Detalhes</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('admin.departamentos.index') }}">Voltar</a>
    <a href="{{ route('admin.departamentos.edit', $departamento->id) }}">Editar</a>

    <form action="{{ route('admin.departamentos.destroy', $departamento->id) }}" method="POST" style="display:inline" class="delete-form">
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
