<!-- resources/views/turmas/edit.blade.php -->
@extends('layout')

@section('content')
    <h1>Editar Turma</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('turmas.update', $turma->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="letra">Letra:</label>
        <input type="text" name="letra" id="letra" value="{{ $turma->letra }}">

        <label for="ano">Ano:</label>
        <input type="number" name="ano" id="ano" value="{{$turma->ano }}">

        <button type="submit">Atualizar</button>
    </form>

    <a href="{{ route('turmas.index') }}">Voltar</a>
@endsection
