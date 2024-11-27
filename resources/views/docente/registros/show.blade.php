<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalhes do Registro') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('docente.registros.edit', $registro->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white text-sm font-medium rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar
                </a>
                <a href="{{ route('docente.registros.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Voltar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Data</h3>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($registro->data)->format('d/m/Y') }}
                                </p>
                            </div>
                            
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Aluno</h3>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $registro->aluno ? $registro->aluno->nome : 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Turma</h3>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $registro->turma ? $registro->turma->nome : 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Tipo</h3>
                                <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $registro->tipo === 'Advertência' ? 'bg-red-100 text-red-800' : 
                                       ($registro->tipo === 'Registro Disciplinar' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($registro->tipo === 'Nota NAI' ? 'bg-blue-100 text-blue-800' : 
                                       'bg-green-100 text-green-800')) }}">
                                    {{ $registro->tipo }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Descrição</h3>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $registro->descricao }}
                                </p>
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Encaminhado Para</h3>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $registro->setor ? $registro->setor->nome : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($registro->agendamento)
                        <div class="mt-8">
                            <div class="border-t border-gray-200 pt-6">
                                <h3 class="text-lg font-medium text-gray-900">Informações do Agendamento</h3>
                                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-4">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Data</h4>
                                            <p class="mt-1 text-sm text-gray-900">
                                                {{ $registro->agendamento->data_agendamento ? \Carbon\Carbon::parse($registro->agendamento->data_agendamento)->format('d/m/Y') : 'N/A' }}
                                            </p>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Hora</h4>
                                            <p class="mt-1 text-sm text-gray-900">
                                                {{ $registro->agendamento->hora_agendamento ? \Carbon\Carbon::parse($registro->agendamento->hora_agendamento)->format('H:i') : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="space-y-4">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Participantes</h4>
                                            <p class="mt-1 text-sm text-gray-900">
                                                {{ $registro->agendamento->participantes ?? 'N/A' }}
                                            </p>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Local</h4>
                                            <p class="mt-1 text-sm text-gray-900">
                                                {{ $registro->agendamento->local ? $registro->agendamento->local->nome : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mt-8 flex justify-end space-x-3">
                        <form action="{{ route('docente.registros.destroy', $registro->id) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Tem certeza que deseja excluir este registro?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Excluir Registro
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>