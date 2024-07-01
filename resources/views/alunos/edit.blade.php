@extends('layout')

@section('content')
    <h1>Editar Aluno</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('alunos.update', $aluno->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ $aluno->nome }}">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ $aluno->email }}">

        <label for="matricula">Matricula:</label>
        <input type="text" name="matricula" id="matricula" value="{{$aluno->matricula }}">

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="date" name="data_nascimento" id="data_nascimento" value="{{ $aluno->data_nascimento }}">

        <label for="turma_id">Turma</label>
        <select name="turma_id" id="turma">
            @foreach($turmas as $turma)
            <option value="{{$turma->id}}"@if($aluno->turma_id == $turma->id) selected @endif>{{$turma->ano}}°{{$turma->letra}}</option>
            @endforeach
        </select>

        <label for="curso_id">Curso</label>
        <select name="curso_id" id="curso">
            @foreach($cursos as $curso)
                <option value="{{$curso->id}}"@if($aluno->curso_id == $curso->id) selected @endif>{{$curso->nome}}</option>
            @endforeach
        </select>


        <button type="submit">Atualizar</button>
    </form>

    <a href="{{ route('alunos.index') }}">Voltar</a>
@endsection
