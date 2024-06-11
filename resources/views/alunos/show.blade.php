<!-- resources/views/alunos/show.blade.php -->
@extends('layout')

@section('content')
    <h1>Detalhes do Aluno</h1>

    <p><strong>Nome:</strong> {{ $aluno->nome }}</p>
    <p><strong>Email:</strong> {{ $aluno->email }}</p>
    <p><strong>Data de Nascimento:</strong> {{ $aluno->data_nascimento }}</p>
    <p><strong>Matricula:</strong> {{ $aluno->matricula }}</p>
    

    <a href="{{ route('alunos.index') }}">Voltar</a>
    <a href="{{ route('alunos.edit', $aluno->id) }}">Editar</a>

    <form action="{{ route('alunos.destroy', $aluno->id) }}" method="POST" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="submit">Deletar</button>
    </form>
@endsection
