<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meu Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Informações Pessoais -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Informações Pessoais</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Nome</p>
                                    <p class="font-medium">{{ $docente->nome }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Email</p>
                                    <p class="font-medium">{{ $docente->email }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Matrícula</p>
                                    <p class="font-medium">{{ $docente->matricula }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Departamento</p>
                                    <p class="font-medium">{{ $docente->departamento->nome }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>