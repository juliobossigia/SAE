<x-app-layout>
    <div class="container" style="margin-top:-50px;">
        <h1>Registros</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="main-content">
            <div class="performance-section">
                <div class="historico">
                    <div class="head-main-content">
                        <a href="{{ route('registros.index') }}" id="buttonVoltar" class="btn btn-secondary" style="display: none;">Voltar</a>
                    </div>
                    <div class="historico">
                        @if(count($registros) > 0)
                            <table>
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Aluno</th>
                                        <th>Turma</th>
                                        <th>Tipo</th>
                                        <th>Descrição</th>
                                        <th>Encaminhado Para</th>
                                        @if(auth()->user()->role != 'responsavel')
                                            <th>Ações</th>
                                        @endif
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
                                            @if(auth()->user()->role != 'responsavel')
                                                <td>
                                                    <a href="{{ route('registros.show', $registro->id) }}" class="btn-details">Detalhes</a>
                                                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'servidor' || (auth()->user()->role === 'docente' && $registro->user_id === auth()->id()))
                                                        <a href="{{ route('registros.edit', $registro->id) }}" class="btn btn-primary">Editar</a>
                                                        <form action="{{ route('registros.destroy', $registro->id) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este registro?')">Excluir</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Nenhum registro encontrado.</p>
                        @endif
                    </div>
                    <a href="{{ route('registros.create') }}"><button class="btn-novo-registro">Adicionar Novo Registro</button></a>
                    <a href="{{ route('agendamentos.index') }}"><button class="btn-novo-registro">Visualizar Agendamentos</button></a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
