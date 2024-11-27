@extends('layouts.admin')

@section('content')
    <h1>Minhas Disciplinas</h1>
    
    @if($disciplinas->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Código</th>
                    <th>Carga Horária</th>
                </tr>
            </thead>
            <tbody>
                @foreach($disciplinas as $disciplina)
                    <tr>
                        <td>{{ $disciplina->nome }}</td>
                        <td>{{ $disciplina->codigo }}</td>
                        <td>{{ $disciplina->carga_horaria }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Nenhuma disciplina encontrada.</p>
    @endif
@endsection
