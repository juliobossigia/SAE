@extends('layouts.admin')

@section('content')
    <h1>Detalhes do Curso</h1>

    <p><strong>Nome:</strong> {{ $curso->nome }}</p>
    <p><strong>Descrição:</strong> {{ $curso->descricao }}</p>

    <a href="{{ route('admin.cursos.index') }}">Voltar</a>
    <a href="{{ route('admin.cursos.edit', $curso->id) }}">Editar</a>

    <form action="{{ route('admin.cursos.destroy', $curso->id) }}" method="POST" style="display:inline" class="delete-form">
        @csrf
        @method('DELETE')
        <button type="submit">Deletar</button>
    </form>
@endsection
