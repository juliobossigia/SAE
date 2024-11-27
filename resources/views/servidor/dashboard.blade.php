<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard do Servidor
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Cards de Estatísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Card de Registros -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100">
                                <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Total de Registros</p>
                                <p class="text-2xl font-semibold text-gray-700">{{ $totalRegistros }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('servidor.registros.index') }}" class="text-indigo-600 hover:text-indigo-900">Ver todos →</a>
                        </div>
                    </div>
                </div>

                <!-- Card de Agendamentos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Agendamentos Pendentes</p>
                                <p class="text-2xl font-semibold text-gray-700">{{ $agendamentosPendentes }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('servidor.agendamentos.index') }}" class="text-green-600 hover:text-green-900">Ver todos →</a>
                        </div>
                    </div>
                </div>

                <!-- Card do Setor -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100">
                                <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Seu Setor</p>
                                <p class="text-xl font-semibold text-gray-700">{{ $setor->nome ?? 'Não definido' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Registros Recentes e Agendamentos -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Registros Recentes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Registros Recentes</h3>
                        @if($registrosRecentes->isEmpty())
                            <p class="text-gray-500">Nenhum registro recente.</p>
                        @else
                            <div class="space-y-4">
                                @foreach($registrosRecentes as $registro)
                                    <div class="border-b pb-3">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-semibold">{{ $registro->tipo }}</p>
                                                <p class="text-sm text-gray-600">
                                                    Aluno: {{ $registro->aluno->nome ?? 'N/A' }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    {{ date('d/m/Y', strtotime($registro->data)) }}
                                                </p>
                                            </div>
                                            <a href="{{ route('servidor.registros.show', $registro) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 text-sm">
                                                Ver detalhes
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Próximos Agendamentos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Próximos Agendamentos</h3>
                        @if($proximosAgendamentos->isEmpty())
                            <p class="text-gray-500">Nenhum agendamento próximo.</p>
                        @else
                            <div class="space-y-4">
                                @foreach($proximosAgendamentos as $agendamento)
                                    <div class="border-b pb-3">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-semibold">
                                                    {{ date('d/m/Y', strtotime($agendamento->data_agendamento)) }}
                                                    às {{ $agendamento->hora_agendamento }}
                                                </p>
                                                <p class="text-sm text-gray-600">
                                                    Local: {{ $agendamento->local->descricao_completa ?? 'N/A' }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    Status: {{ $agendamento->status }}
                                                </p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                {{ $agendamento->status === 'Pendente' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($agendamento->status === 'Confirmado' ? 'bg-green-100 text-green-800' : 
                                                    'bg-red-100 text-red-800') }}">
                                                {{ $agendamento->status }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>