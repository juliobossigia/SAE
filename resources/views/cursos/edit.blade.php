@extends('layout')

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

    <form action="{{ route('cursos.update', $curso->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ $curso->nome }}">


        <button type="submit">Atualizar</button>
    </form>

    <a href="{{ route('docentes.index') }}">Voltar</a>
@endsection
