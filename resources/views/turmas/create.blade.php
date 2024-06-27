<!-- resources/views/turmas/create.blade.php -->
@extends('layout')

@section('content')
    <h1>Adicionar Turma</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('turmas.store') }}" method="POST">
        @csrf
        <label for="letra">Letra:</label>
        <input type="text" name="letra" id="letra" value="{{ old('letra') }}">

        <label for="ano">Ano:</label>
        <input type="number" name="ano" id="ano" value="{{ old('ano')}}">
    

        <button type="submit">Salvar</button>
    </form>

    <a href="{{ route('turmas.index') }}">Voltar</a>
@endsection
