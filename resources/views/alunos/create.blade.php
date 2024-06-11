<!-- resources/views/alunos/create.blade.php -->
@extends('layout')

@section('content')
    <h1>Adicionar Aluno</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('alunos.store') }}" method="POST">
        @csrf
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ old('nome') }}">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">

        <label for="matricula">Matricula:</label>
        <input type="text" name="matricula" id="matricula" value="{{ old('matricula')}}">
        
        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" name="data_nascimento" id="data_nascimento" value="{{ old('data_nascimento') }}">

        <button type="submit">Salvar</button>
    </form>

    <a href="{{ route('alunos.index') }}">Voltar</a>
@endsection
