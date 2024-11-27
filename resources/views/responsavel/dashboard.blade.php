<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard do Responsável') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Card de Alunos -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-4">Meus Alunos</h3>
                            <a href="{{ route('responsavel.alunos') }}" 
                               class="text-blue-600 hover:text-blue-800">
                                Ver todos os alunos →
                            </a>
                        </div>

                        <!-- Card de Perfil -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-4">Meu Perfil</h3>
                            <a href="{{ route('responsavel.perfil') }}" 
                               class="text-blue-600 hover:text-blue-800">
                                Visualizar perfil →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
