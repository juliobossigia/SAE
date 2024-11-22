@extends('layouts.admin')


@section('content')
    <header>
    <h1>Lista de Alunos</h1>
    <a href="{{ route('admin.alunos.create') }}">Adicionar Aluno</a>
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
            <th>Matricula</th>
            <th>Curso</th>
            <th>Ações</th>
        </tr>
        @foreach ($alunos as $aluno)
            <tr>
                <td>{{ $aluno->nome }}</td>
                <td>{{ $aluno->email }}</td>
                <td>{{ $aluno->matricula }}</td>
                <td>{{ $aluno->curso->nome }}</td>
                <td>
                    <a href="{{ route('admin.alunos.show', $aluno->id) }}">Ver</a>
                    <a href="{{ route('admin.alunos.edit', $aluno->id) }}">Editar</a>
                    <form action="{{ route('admin.alunos.destroy', $aluno->id) }}" method="POST" style="display:inline" class="delete-form">
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
