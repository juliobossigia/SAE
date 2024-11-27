<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalhes do Registro
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <a href="{{ route('servidor.registros.index') }}" class="text-blue-600 hover:text-blue-900">
                            ← Voltar para lista
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="font-bold mb-2">Informações Básicas</h3>
                            <p><strong>Data:</strong> {{ date('d/m/Y', strtotime($registro->data)) }}</p>
                            <p><strong>Tipo:</strong> {{ $registro->tipo }}</p>
                            <p><strong>Aluno:</strong> {{ $registro->aluno->nome ?? 'N/A' }}</p>
                            <p><strong>Turma:</strong> {{ $registro->turma->nome ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <h3 class="font-bold mb-2">Detalhes</h3>
                            <p><strong>Setor:</strong> {{ $registro->setor->nome ?? 'N/A' }}</p>
                            <p><strong>Criado por:</strong> {{ $registro->criadoPor->name ?? 'N/A' }}</p>
                            <p><strong>Data de criação:</strong> {{ $registro->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h3 class="font-bold mb-2">Descrição</h3>
                        <p class="whitespace-pre-line">{{ $registro->descricao }}</p>
                    </div>

                    @if($registro->agendamento && $registro->agendamento()->exists())
                        <div class="mt-4">
                            <h3 class="font-bold mb-2">Agendamento</h3>
                            @php
                                $agendamentoObj = $registro->agendamento()->first();
                            @endphp
                            @if($agendamentoObj)
                                <p><strong>Data:</strong> {{ $agendamentoObj->data_agendamento ? $agendamentoObj->data_agendamento->format('d/m/Y') : 'N/A' }}</p>
                                <p><strong>Hora:</strong> {{ $agendamentoObj->hora_agendamento ? $agendamentoObj->hora_agendamento->format('H:i') : 'N/A' }}</p>
                                <p><strong>Local:</strong> {{ optional($agendamentoObj->local)->descricao_completa ?? 'N/A' }}</p>
                                <p><strong>Participantes:</strong> {{ $agendamentoObj->participantes ?? 'N/A' }}</p>
                                <p><strong>Status:</strong> {{ $agendamentoObj->status ?? 'N/A' }}</p>
                            @else
                                <p>Nenhum detalhe de agendamento encontrado.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>