@extends('layout')

@section('content')
    <h1>Adicionar Disciplina</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.disciplinas.store') }}" method="POST">
        @csrf
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ old('nome') }}">

        <!-- Campo de seleção de Departamento -->
        <label for="departamento_id">Departamento:</label>
        <select name="departamento_id" id="departamento_id">
         @foreach($departamentos as $departamento)
            <option value="{{ $departamento->id }}">{{ $departamento->nome }}</option>
         @endforeach
        </select>

        <button type="submit">Salvar</button>
    </form>

    <a href="{{ route('admin.disciplinas.index') }}">Voltar</a>
@endsection
