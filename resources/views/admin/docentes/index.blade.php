@extends('layout')


@section('content')
    <header>
    <h1>Lista de Docentes</h1>
    <a href="{{ route('admin.docentes.create') }}">Adicionar Docente</a>
    @livewire('logout-button')
    <br>
    </header>


    @if ($message = Session::get('success'))
        <div>
            {{ $message }}
        
        </div>
    @endif
   
    <table>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Departamento</th>
            <th>Curso</th>
            <th>Ações</th>
        </tr>
        @foreach ($docentes as $docente)
            <tr>
                <td>{{ $docente->nome }}
                @if($docente->is_coordenador)
                <span class="badge badge-primary">Coordenador</span>
                @endif
                </td>
                <td>{{ $docente->email }}</td>
                <td>{{ $docente->departamento->nome}}</td>
                <td>{{ $docente->curso ? $docente->curso->nome : 'Sem curso' }}</td>
                <td>
                    <a href="{{ route('admin.docentes.show', $docente->id) }}">Ver</a>
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
                </td>
            </tr>
        @endforeach
    </table>
    <div>
        <br>
        <a href="{{ route('admin.dashboard')}}">Voltar</a>
    </div>
    <footer>
        <br>
    </footer>
@endsection
