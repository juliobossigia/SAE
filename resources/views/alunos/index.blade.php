<!-- resources/views/alunos/index.blade.php -->
@extends('layout')


@section('content')
    <header>
    <h1>Lista de Alunos</h1>
    <a href="{{ route('alunos.create') }}">Adicionar Aluno</a>
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
            <th>Data de Nascimento</th>
            <th>Matricula</th>
            <th>Ações</th>
        </tr>
        @foreach ($alunos as $aluno)
            <tr>
                <td>{{ $aluno->nome }}</td>
                <td>{{ $aluno->email }}</td>
                <td>{{ $aluno->data_nascimento }}</td>
                <td>{{ $aluno->matricula }}</td>
                <td>
                    <a href="{{ route('alunos.show', $aluno->id) }}">Ver</a>
                    <a href="{{ route('alunos.edit', $aluno->id) }}">Editar</a>
                    <form action="{{ route('alunos.destroy', $aluno->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Deletar</button>
                    </form>
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
