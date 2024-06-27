<!-- resources/views/setores/edit.blade.php -->
@extends('layout')

@section('content')
    <h1>Editar Setor</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('setores.update', $setor->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ $setor->nome }}" required>

        <br>
        <button type="submit">Atualizar</button>
    </form>

    <br>
    <a href="{{ route('setores.index') }}">Voltar</a>
@endsection
