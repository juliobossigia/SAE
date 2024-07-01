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
            <label for="curso_id">Curso:</label>
            <select name="curso_id" id="curso" required>
                <option value="">Selecione um curso</option>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}">{{ $curso->nome }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <br>
            <label for="turma_id">Turma:</label>
            <select name="turma_id" id="turma" required>
                <option value="">Selecione um curso primeiro</option>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cursoSelect = document.getElementById('curso');
            const turmaSelect = document.getElementById('turma');

            cursoSelect.addEventListener('change', function() {
                const cursoId = this.value;

                fetch(`/api/cursos/${cursoId}/turmas`)
                    .then(response => response.json())
                    .then(data => {
                        turmaSelect.innerHTML = '<option value="">Selecione uma turma</option>';
                        data.forEach(turma => {
                            const option = document.createElement('option');
                            option.value = turma.id;
                            option.textContent = `${turma.ano}°${turma.letra}`;
                            turmaSelect.appendChild(option);
                        });
                    });
            });
        });
    </script>
@endsection
