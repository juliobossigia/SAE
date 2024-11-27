<x-app-layout>
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Meus Agendamentos</h1>
                <a href="{{ route('docente.registros.create') }}" class="btn btn-primary">
                    Novo Registro/Agendamento
                </a>
            </div> 
            <div class="card-body">
                @if($registros->isEmpty())
                    <div class="alert alert-info">
                        Você ainda não possui agendamentos registrados.
                    </div>
                @else
                    @foreach($registros as $registro)
                        @foreach($registro->agendamentos as $agendamento)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h5 class="card-title">
                                                Aluno: {{ $registro->aluno->nome }}
                                            </h5>
                                            <p class="card-text">
                                                <strong>Data:</strong> 
                                                {{ $agendamento->data_agendamento->format('d/m/Y') }}
                                                <br>
                                                <strong>Hora:</strong> 
                                                {{ $agendamento->hora_agendamento }}
                                                <br>
                                                <strong>Local:</strong> 
                                                {{ $agendamento->local->nome }}
                                                <br>
                                                <strong>Participantes:</strong> 
                                                {{ $agendamento->participantes }}
                                            </p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="badge bg-{{ $agendamento->status == 'Pendente' ? 'warning' : 
                                                ($agendamento->status == 'Confirmado' ? 'success' : 
                                                ($agendamento->status == 'Cancelado' ? 'danger' : 'info')) }}">
                                                {{ $agendamento->status }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>