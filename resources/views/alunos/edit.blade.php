<!-- resources/views/alunos/edit.blade.php -->
@extends('layout')

@section('content')
    <h1>Editar Aluno</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('alunos.update', $aluno->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ $aluno->nome }}">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ $aluno->email }}">

        <label for="matricula">Matricula:</label>
        <input type="text" name="matricula" id="matricula" value="{{$aluno->matricula }}">

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" name="data_nascimento" id="data_nascimento" value="{{ $aluno->data_nascimento }}">

        <button type="submit">Atualizar</button>
    </form>

    <a href="{{ route('alunos.index') }}">Voltar</a>
@endsection
