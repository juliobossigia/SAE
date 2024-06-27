<!-- resources/views/setores/show.blade.php -->
@extends('layout')

@section('content')
    <h1>Detalhes do Setor</h1>

    <p><strong>ID:</strong> {{ $setor->id }}</p>
    <p><strong>Nome:</strong> {{ $setor->nome }}</p>

    <a href="{{ route('setores.index') }}">Voltar</a>
    <a href="{{ route('setores.edit', $setor->id) }}">Editar</a>

    <form action="{{ route('setores.destroy', $setor->id) }}" method="POST" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="submit">Deletar</button>
    </form>
@endsection
