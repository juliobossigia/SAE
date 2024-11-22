@extends('layouts.admin')

@section('content')
    <h1>Editar Curso</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.cursos.update', $curso->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="{{ $curso->nome }}" required>
        </div>

        <div>
            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" required>{{ $curso->descricao }}</textarea>
        </div>

        <div>
            <button type="submit">Atualizar</button>
        </div>
    </form>

    <a href="{{ route('admin.cursos.index') }}">Voltar</a>
@endsection
