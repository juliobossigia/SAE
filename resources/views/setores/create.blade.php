<!-- resources/views/setores/create.blade.php -->
@extends('layout')

@section('content')
    <h1>Adicionar Setor</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('setores.store') }}" method="POST">
        @csrf
        
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required>
       
        <br>
        <button type="submit">Salvar</button>
    </form>

    <br>
    <a href="{{ route('setores.index') }}">Voltar</a>
@endsection
