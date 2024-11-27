<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Agendamentos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Lista de Agendamentos</h3>
                        <a href="{{ route('servidor.agendamentos.create') }}" class="btn btn-primary">
                            Novo Agendamento
                        </a>
                    </div>

                    @if($agendamentos->isEmpty())
                        <p class="text-gray-500 text-center py-4">Nenhum agendamento encontrado.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2">Data</th>
                                        <th class="px-4 py-2">Hora</th>
                                        <th class="px-4 py-2">Local</th>
                                        <th class="px-4 py-2">Status</th>
                                        <th class="px-4 py-2">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($agendamentos as $agendamento)
                                        <tr>
                                            <td class="border px-4 py-2">
                                                {{ date('d/m/Y', strtotime($agendamento->data_agendamento)) }}
                                            </td>
                                            <td class="border px-4 py-2">
                                                {{ $agendamento->hora_agendamento }}
                                            </td>
                                            <td class="border px-4 py-2">
                                                {{ $agendamento->local->descricao_completa ?? 'N/A' }}
                                            </td>
                                            <td class="border px-4 py-2">
                                                <span class="px-2 py-1 text-xs rounded-full 
                                                    {{ $agendamento->status === 'Pendente' ? 'bg-yellow-100 text-yellow-800' : 
                                                       ($agendamento->status === 'Confirmado' ? 'bg-green-100 text-green-800' : 
                                                        'bg-red-100 text-red-800') }}">
                                                    {{ $agendamento->status }}
                                                </span>
                                            </td>
                                            <td class="border px-4 py-2">
                                                <a href="{{ route('servidor.agendamentos.show', $agendamento) }}" 
                                                   class="text-blue-600 hover:text-blue-900">
                                                    Ver
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $agendamentos->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>