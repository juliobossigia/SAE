<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registros
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Lista de Registros</h3>
                        <a href="{{ route('servidor.registros.create') }}" class="btn btn-primary">
                            Novo Registro
                        </a>
                    </div>

                    @if($registros->isEmpty())
                        <p class="text-gray-500 text-center py-4">Nenhum registro encontrado.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2">Data</th>
                                        <th class="px-4 py-2">Aluno</th>
                                        <th class="px-4 py-2">Turma</th>
                                        <th class="px-4 py-2">Tipo</th>
                                        <th class="px-4 py-2">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registros as $registro)
                                        <tr>
                                            <td class="border px-4 py-2">{{ date('d/m/Y', strtotime($registro->data)) }}</td>
                                            <td class="border px-4 py-2">{{ $registro->aluno->nome ?? 'N/A' }}</td>
                                            <td class="border px-4 py-2">{{ $registro->turma->nome ?? 'N/A' }}</td>
                                            <td class="border px-4 py-2">{{ $registro->tipo }}</td>
                                            <td class="border px-4 py-2">
                                                <a href="{{ route('servidor.registros.show', $registro) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $registros->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>