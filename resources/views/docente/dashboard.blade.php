<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-500">Último acesso: {{ auth()->user()->last_login_at?->format('d/m/Y H:i') ?? 'Primeiro acesso' }}</span>
                <span class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-full text-sm font-medium">
                    Docente
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Cards de Estatísticas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Card de Registros -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="p-3 bg-indigo-50 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Registros</h3>
                                    <p class="text-3xl font-bold text-indigo-600">{{ $totalRegistros }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('docente.registros.create') }}" 
                               class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Novo Registro
                            </a>
                            <a href="{{ route('docente.registros.index') }}" 
                               class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                Ver todos
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card de Agendamentos -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="p-3 bg-emerald-50 rounded-lg">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Agendamentos</h3>
                                    <p class="text-3xl font-bold text-emerald-600">{{ $totalAgendamentos }}</p>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('docente.agendamentos.index') }}" 
                           class="w-full inline-flex justify-center items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-md hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                            Ver Agendamentos
                        </a>
                    </div>
                </div>
            </div>

            <!-- Atividades Recentes -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Atividades Recentes</h3>
                        <a href="#" class="text-sm text-indigo-600 hover:text-indigo-900">Ver todas</a>
                    </div>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($atividades ?? [] as $atividade)
                        <div class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <span class="p-2 rounded-full" style="background-color: {{ $atividade->cor_tipo ?? '#EEE' }}">
                                        <!-- Ícone baseado no tipo de atividade -->
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $atividade->descricao ?? 'Descrição da atividade' }}</p>
                                    <p class="text-sm text-gray-500">{{ $atividade->created_at?->diffForHumans() ?? 'há alguns instantes' }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-4">
                            <p class="text-sm text-gray-500 text-center">Nenhuma atividade recente encontrada</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>