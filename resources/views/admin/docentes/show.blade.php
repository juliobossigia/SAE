@extends('layouts.admin')

@section('content')
    <h1>Detalhes do Docente</h1>

    <p>
    <strong>Nome:</strong> {{ $docente->nome }} 
    {{ $docente->is_coordenador ? '<span class="badge badge-primary">Coordenador</span>' : '' }}
    </p>


    <h2>Disciplinas Lecionadas</h2>
    @if($docente->disciplinas->isEmpty())
    <p>Este docente não leciona nenhuma disciplina.</p>
    @else
    <ul>
        @foreach($docente->disciplinas as $disciplina)
            <li>{{ $disciplina->nome }}</li>
        @endforeach
    </ul>
    @endif
   
    <p><strong>Email:</strong> {{ $docente->email }}</p>
    <p><strong>Data de Nascimento:</strong> {{ $docente->data_nascimento }}</p>
    <p><strong>CPF:</strong> {{ $docente->cpf }}</p>
    

    <a href="{{ route('admin.docentes.index') }}">Voltar</a>
    <a href="{{ route('admin.docentes.edit', $docente->id) }}">Editar</a>

    <form action="{{ route('admin.docentes.destroy', $docente->id) }}" method="POST" style="display:inline" class="delete-form">
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
