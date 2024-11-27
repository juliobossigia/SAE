<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Alunos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($alunos->isEmpty())
                        <p>Nenhum aluno encontrado.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($alunos as $aluno)
                                <div class="p-4 border rounded-lg shadow">
                                    <h3 class="font-bold text-lg">{{ $aluno->nome }}</h3>
                                    <p class="text-gray-600">Matrícula: {{ $aluno->matricula }}</p>
                                    
                                    <div class="mt-4 space-y-2">
                                        <a href="{{ route('responsavel.aluno.registros', $aluno->id) }}" 
                                           class="block text-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                            Ver Registros
                                        </a>
                                        <a href="{{ route('responsavel.aluno.agendamentos', $aluno->id) }}" 
                                           class="block text-center bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                            Ver Agendamentos
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>