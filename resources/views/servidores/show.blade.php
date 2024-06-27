<!-- resources/views/servidores/show.blade.php -->
@extends('layout')

@section('content')
    <h1>Detalhes do Servidor</h1>

    <p><strong>Nome:</strong> {{ $servidor->nome }}</p>
    <p><strong>Email:</strong> {{ $servidor->email }}</p>
    <p><strong>CPF:</strong> {{ $servidor->cpf }}</p>
    <p><strong>Setor:</strong> {{ $servidor->setor->nome }}</p>

    <a href="{{ route('servidores.index') }}">Voltar</a>
    <a href="{{ route('servidores.edit', $servidor->id) }}">Editar</a>

    <form action="{{ route('servidores.destroy', $servidor->id) }}" method="POST" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="submit">Deletar</button>
    </form>
@endsection
