@extends('layout')

@section('content')
    <h1>Adicionar Prédio</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.predios.store') }}" method="POST">
        @csrf
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ old('nome') }}">
        
        <button type="submit">Salvar</button>
    </form>

    <a href="{{ route('admin.predios.index') }}">Voltar</a>
@endsection
