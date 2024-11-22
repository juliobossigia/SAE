<x-app-layout>
    <div class="container py-4">
        <!-- Cabeçalho -->
        <div class="card shadow-sm mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-gray-800">Registros</h1>
                <div class="button-group">
                    <a href="{{ route('admin.registros.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus-circle me-2"></i>Novo Registro
                    </a>
                    <a href="{{ route('admin.agendamentos.index') }}" class="btn btn-info btn-lg ms-2">
                        <i class="fas fa-calendar-alt me-2"></i>Agendamentos
                    </a>
                </div>
            </div>
        </div>

        <!-- Alertas -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Conteúdo Principal -->
        <div class="card shadow">
            <div class="card-body">
                @if(count($registros) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Data</th>
                                    <th>Aluno</th>
                                    <th>Turma</th>
                                    <th>Tipo</th>
                                    <th>Descrição</th>
                                    <th>Encaminhado Para</th>
                                    @if(auth()->user()->role != 'responsavel')
                                        <th class="text-center">Ações</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registros as $registro)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($registro->data)->format('d/m/Y') }}</td>
                                        <td>{{ $registro->aluno ? $registro->aluno->nome : 'N/A' }}</td>
                                        <td>{{ $registro->turma ? $registro->turma->nome : 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $registro->tipo === 'Advertência' ? 'danger' : 
                                                ($registro->tipo === 'Registro Disciplinar' ? 'warning' : 
                                                ($registro->tipo === 'Nota NAI' ? 'info' : 'success')) }}">
                                                {{ $registro->tipo }}
                                            </span>
                                        </td>
                                        <td>{{ Str::limit($registro->descricao, 50) }}</td>
                                        <td>{{ $registro->encaminhado_para }}</td>
                                        @if(auth()->user()->role != 'responsavel')
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.registros.show', $registro->id) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="Detalhes">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'servidor' || (auth()->user()->role === 'docente' && $registro->user_id === auth()->id()))
                                                        <a href="{{ route('admin.registros.edit', $registro->id) }}" 
                                                           class="btn btn-sm btn-warning" 
                                                           title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.registros.destroy', $registro->id) }}" 
                                                              method="POST" 
                                                              class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-danger" 
                                                                    title="Excluir"
                                                                    onclick="return confirm('Tem certeza que deseja excluir este registro?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Nenhum registro encontrado</h4>
                        <p class="text-muted">Clique no botão "Novo Registro" para adicionar um registro.</p>
                        <a href="{{ route('admin.registros.create') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-plus-circle me-2"></i>Adicionar Primeiro Registro
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Adicione estes estilos ao seu CSS -->
    <style>
        .card {
            border-radius: 10px;
            border: none;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
        }
        
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
            margin: 0 2px;
        }
        
        .badge {
            padding: 0.5em 0.8em;
            font-weight: 500;
        }
        
        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
        }
        
        .shadow {
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .button-group .btn {
            padding: 0.5rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .button-group .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .h3 {
            font-size: 1.75rem;
            color: #2c3e50;
        }
    </style>
</x-app-layout>
