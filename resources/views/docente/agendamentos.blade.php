<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Agendamentos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($agendamentos->count() > 0)
                        <div class="grid gap-4">
                            @foreach($agendamentos as $agendamento)
                                <div class="border p-4 rounded-lg shadow-sm">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-semibold">
                                                Registro: {{ $agendamento->registro->aluno->nome }}
                                            </h3>
                                            <p class="text-sm text-gray-600">
                                                Data: {{ $agendamento->data_agendamento->format('d/m/Y') }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                Hora: {{ $agendamento->hora_agendamento }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                Local: {{ $agendamento->local->nome }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                Participantes: {{ $agendamento->participantes }}
                                            </p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-sm 
                                            @if($agendamento->status == 'Confirmado') bg-green-100 text-green-800
                                            @elseif($agendamento->status == 'Pendente') bg-yellow-100 text-yellow-800
                                            @elseif($agendamento->status == 'Cancelado') bg-red-100 text-red-800
                                            @else bg-blue-100 text-blue-800
                                            @endif">
                                            {{ $agendamento->status }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">Você não possui agendamentos registrados.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>