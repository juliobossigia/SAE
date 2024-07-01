@extends('layout')

@section('content')
    <h1>Editar Docente</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('docentes.update', $docente->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ $docente->nome }}">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ $docente->email }}">

        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" id="cpf" value="{{$docente->cpf }}">

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" name="data_nascimento" id="data_nascimento" value="{{ $docente->data_nascimento }}">

        <button type="submit">Atualizar</button>
    </form>

    <a href="{{ route('docentes.index') }}">Voltar</a>
@endsection
