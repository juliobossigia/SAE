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
                    <div class="space-y-4">
                        <div>
                            <strong class="text-gray-700">Nome:</strong>
                            <p>{{ $responsavel->nome }}</p>
                        </div>
                        <div>
                            <strong class="text-gray-700">Email:</strong>
                            <p>{{ $responsavel->email }}</p>
                        </div>
                        <div>
                            <strong class="text-gray-700">CPF:</strong>
                            <p>{{ $responsavel->cpf }}</p>
                        </div>
                        <div>
                            <strong class="text-gray-700">Telefone:</strong>
                            <p>{{ $responsavel->telefone }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>