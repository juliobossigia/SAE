@extends('layouts.admin')

@section('content')
    <h1>Editar Prédio</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.predios.update', $predio->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ old('nome', $predio->nome) }}">
        
        <button type="submit">Salvar</button>
    </form>

    <a href="{{ route('admin.predios.index') }}">Voltar</a>
@endsection
