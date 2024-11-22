<x-app-layout>
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header">
                <h1 class="h3 mb-0">Detalhes do Registro</h1>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($registro->data)->format('d/m/Y') }}</p>
                        <p><strong>Aluno:</strong> {{ $registro->aluno ? $registro->aluno->nome : 'N/A' }}</p>
                        <p><strong>Turma:</strong> {{ $registro->turma ? $registro->turma->nome : 'N/A' }}</p>
                        <p><strong>Tipo:</strong> 
                            <span class="badge bg-{{ $registro->tipo === 'Advertência' ? 'danger' : 
                                ($registro->tipo === 'Registro Disciplinar' ? 'warning' : 
                                ($registro->tipo === 'Nota NAI' ? 'info' : 'success')) }}">
                                {{ $registro->tipo }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Descrição:</strong> {{ $registro->descricao }}</p>
                        <p><strong>Encaminhado Para:</strong> {{ $registro->setor ? $registro->setor->nome : 'N/A' }}</p>
                        <p><strong>Criado Por:</strong> {{ $registro->criadoPor ? $registro->criadoPor->name : 'N/A' }}</p>
                    </div>
                </div>

                @if($registro->agendamento)
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="h5 mb-0">Informações do Agendamento</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Data:</strong> {{ $registro->data_agendamento ? \Carbon\Carbon::parse($registro->data_agendamento)->format('d/m/Y') : 'N/A' }}</p>
                        <p><strong>Hora:</strong> {{ $registro->hora_agendamento ? \Carbon\Carbon::parse($registro->hora_agendamento)->format('H:i') : 'N/A' }}</p>
                        <p><strong>Participantes:</strong> {{ $registro->participantes ?? 'N/A' }}</p>
                        <p><strong>Local:</strong> {{ $registro->local ? $registro->local->nome : 'N/A' }}</p>
                    </div>
                </div>
                @endif

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.registros.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </a>
                    <a href="{{ route('admin.registros.edit', $registro->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                    <form action="{{ route('admin.registros.destroy', $registro->id) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Tem certeza que deseja excluir este registro?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border-radius: 10px;
            border: none;
        }
        
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }
        
        .badge {
            padding: 0.5em 0.8em;
            font-weight: 500;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }
        
        .gap-2 {
            gap: 0.5rem;
        }
    </style>
</x-app-layout>
