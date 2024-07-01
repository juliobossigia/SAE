@extends('layout')

@section('content')
    <h1>Detalhes do Curso</h1>

    <p><strong>Nome:</strong> {{ $curso->nome }}</p>

    <h2>Turmas do Curso</h2>
    @if($curso->turmas->isEmpty())
        <p>Não há turmas cadastradas neste curso.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Letra</th>
                    <th>Ano</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($curso->turmas as $turma)
                <tr>
                    <td>{{ $turma->letra }}</td>  
                    <td>{{ $turma->ano }}</td>
                    <td><a href="{{ route('turmas.show', $turma->id) }}">Ver</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('cursos.index') }}">Voltar</a>
    <a href="{{ route('cursos.edit', $curso->id) }}">Editar</a>

    <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="submit">Deletar</button>
    </form>
@endsection
