@extends('layouts.admin')

@section('content')
    <h1>Adicionar Curso</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.cursos.store') }}" method="POST">
        @csrf
        
        <div>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required>
        </div>

        <div>
            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" required>{{ old('descricao') }}</textarea>
        </div>

        <div>
            <button type="submit">Salvar</button>
        </div>
    </form>

    <a href="{{ route('admin.cursos.index') }}">Voltar</a>
@endsection
