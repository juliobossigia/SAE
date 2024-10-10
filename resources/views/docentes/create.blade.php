@extends('layout')

@section('content')
    <h1>Adicionar Docente</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('docentes.store') }}" method="POST">
        @csrf
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ old('nome') }}">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">

        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}">
        
        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" name="data_nascimento" id="data_nascimento" value="{{ old('data_nascimento') }}">

        <label for="disciplinas">Disciplinas:</label>
        <select name="disciplinas[]" id="disciplinas" multiple>
            @foreach($disciplinas as $disciplina)
            <option value="{{ $disciplina->id }}" {{ in_array($disciplina->id, old('disciplinas', [])) ? 'selected' : '' }}>
                {{ $disciplina->nome }}
            </option>
            @endforeach
        </select>
        <br>

        <label for="departamento_id">Departamento:</label>
        <select name="departamento_id" id="departamento_id">
        @foreach($departamentos as $departamento)
            <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                {{ $departamento->nome }}
            </option>
        @endforeach
        </select>
        
        <div>
            <label for="is_coordenador">É Coordenador?</label>
            <input type="checkbox" name="is_coordenador" value="1" {{ old('is_coordenador') ? 'checked' : '' }}>
        </div>

        <div>
            <label for="curso_id">Curso</label>
            <select name="curso_id">
                <option value="">Selecione um curso</option>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}" {{ old('curso_id') == $curso->id ? 'selected' : '' }}>
                        {{ $curso->nome }}
                    </option>
                @endforeach
            </select>    
        </div>

        <button type="submit">Salvar</button>
    </form>

    <a href="{{ route('docentes.index') }}">Voltar</a>
@endsection
