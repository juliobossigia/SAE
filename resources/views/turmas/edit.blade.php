@extends('layout')

@section('content')
    <h1>Editar Turma</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('turmas.update', $turma->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="letra">Letra:</label>
        <input type="text" name="letra" id="letra" value="{{ $turma->letra }}">

        <label for="ano">Ano:</label>
        <input type="number" name="ano" id="ano" value="{{$turma->ano }}">

        <label for="curso_id">Curso:</label>
            <select name="curso_id" id="curso_id" required>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}" {{ (isset($turma) && $turma->curso_id == $curso->id) ? 'selected' : '' }}>
                        {{ $curso->nome }}
                    </option>
                @endforeach
            </select>

        <button type="submit">Atualizar</button>
    </form>

    <a href="{{ route('turmas.index') }}">Voltar</a>
@endsection
