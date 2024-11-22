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

    <form action="{{ route('admin.turmas.store') }}" method="POST">
        @csrf
        <label for="letra">Letra:</label>
        <input type="text" name="letra" id="letra" value="{{ old('letra') }}">

        <label for="ano">Ano:</label>
        <input type="number" name="ano" id="ano" value="{{ old('ano')}}">

        <label for="curso_id">Curso:</label>
            <select name="curso_id" id="curso_id" required>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}" {{ (isset($turma) && $turma->curso_id == $curso->id) ? 'selected' : '' }}>
                        {{ $curso->nome }}
                    </option>
                @endforeach
            </select>

        <button type="submit">Salvar</button>
    </form>

    <a href="{{ route('admin.turmas.index') }}">Voltar</a>
@endsection
