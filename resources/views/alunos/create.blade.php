<!-- resources/views/alunos/create.blade.php -->
@extends('layout')

@section('content')
    <h1>Adicionar Aluno</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('alunos.store') }}" method="POST">
        @csrf
        
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required>
        

       
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
       

       
            <label for="matricula">Matrícula:</label>
            <input type="text" name="matricula" id="matricula" value="{{ old('matricula') }}" required>
        
       
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" name="data_nascimento" id="data_nascimento" value="{{ old('data_nascimento') }}" required>
        
            
            <div>
              <br> 
            <label for="turma_id">Turma:</label>
            <select name="turma_id" id="turma" required>
                @foreach($turmas as $turma)
                    <option value="{{ $turma->id }}">{{ $turma->ano }}°{{ $turma->letra }}</option>
                @endforeach
            </select>
       
            
            <label for="curso_id">Curso:</label>
            <select name="curso_id" id="curso" required>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}">{{ $curso->nome }}</option>
                @endforeach
            </select>
            </div>

        <div>
            <br>
            <br>
            <button type="submit">Salvar</button>
        </div>
        <br>
    </form>

    <a href="{{ route('alunos.index') }}">Voltar</a>
@endsection
