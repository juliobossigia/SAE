<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agendamentos de ') . $aluno->nome }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('responsavel.alunos') }}" 
                           class="text-blue-600 hover:text-blue-800">
                            ← Voltar para lista de alunos
                        </a>
                    </div>

                    @forelse($agendamentos as $agendamento)
                        <div class="mb-4 p-4 border rounded-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold">
                                        {{ $agendamento->titulo }}
                                    </h3>
                                    <p class="text-gray-600">
                                        Data: {{ $agendamento->data_hora->format('d/m/Y H:i') }}
                                    </p>
                                    <p class="text-gray-600">
                                        Local: {{ $agendamento->local->nome }}
                                    </p>
                                    <p class="text-gray-600">
                                        Status: {{ $agendamento->status }}
                                    </p>
                                    <p class="mt-2">
                                        {{ $agendamento->descricao }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-600">Nenhum agendamento encontrado para este aluno.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>