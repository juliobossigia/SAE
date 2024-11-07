@extends('layouts.app')

@section('content')
    <h1>Registros</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container" style="margin-top:-50px;">
        <div class="main-content">
            <div class="performance-section">
                <div class="historico">
                    <div class="head-main-content">
                        <a href="{{ route('registros.index') }}" id="buttonVoltar" class="btn btn-secondary" style="display: none;">Voltar</a>
                    </div>
                    <div class="historico">
                        <table>
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Aluno</th>
                                    <th>Turma</th>
                                    <th>Tipo</th>
                                    <th>Descrição</th>
                                    <th>Encaminhado Para</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registros as $registro)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($registro->data)->format('d/m/Y') }}</td>
                                        <td>{{ $registro->aluno ? $registro->aluno->nome : 'N/A' }}</td>
                                        <td>{{ $registro->turma ? $registro->turma->nome : 'N/A' }}</td>
                                        <td>{{ $registro->tipo }}</td>
                                        <td>{{ $registro->descricao }}</td>
                                        <td>{{ $registro->encaminhado_para }}</td>
                                        <td>
                                            <a href="{{ route('registros.show', $registro->id) }}" class="btn-details">Detalhes</a>
                                            <a href="{{ route('registros.edit', $registro->id) }}" class="btn btn-primary">Editar</a>
                                            <form action="{{ route('registros.destroy', $registro->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este registro?')">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $registros->links() }}
                    </div>
                    <a href="{{ route('registros.create') }}"><button class="btn-novo-registro">Adicionar Novo Registro</button></a>
                    <a href="{{ route('agendamentos.index') }}"><button class="btn-novo-registro">Visualizar Agendamentos</button></a>
                </div>
            </div>
        </div>
    </div>
@endsection
