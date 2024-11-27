<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar Registro') }}
            </h2>
            <a href="{{ route('docente.registros.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <ul class="list-disc list-inside text-sm text-red-600">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('docente.registros.update', $registro->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="data" class="block text-sm font-medium text-gray-700">Data</label>
                                <input type="date" 
                                       name="data" 
                                       id="data" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                       value="{{ old('data', $registro->data) }}" 
                                       required>
                            </div>

                            <div>
                                <label for="turma_id" class="block text-sm font-medium text-gray-700">Turma</label>
                                <select name="turma_id" 
                                        id="turma_id" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                        required>
                                    <option value="">Selecione uma turma</option>
                                    @foreach($turmas as $turma)
                                        <option value="{{ $turma->id }}" {{ old('turma_id', $registro->turma_id) == $turma->id ? 'selected' : '' }}>
                                            {{ $turma->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="aluno_id" class="block text-sm font-medium text-gray-700">Aluno</label>
                                <select name="aluno_id" 
                                        id="aluno_id" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Selecione um aluno</option>
                                    @foreach($alunos as $aluno)
                                        <option value="{{ $aluno->id }}" {{ old('aluno_id', $registro->aluno_id) == $aluno->id ? 'selected' : '' }}>
                                            {{ $aluno->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                                <select name="tipo" 
                                        id="tipo" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                        required>
                                    <option value="Advertência" {{ old('tipo', $registro->tipo) == 'Advertência' ? 'selected' : '' }}>Advertência</option>
                                    <option value="Registro Disciplinar" {{ old('tipo', $registro->tipo) == 'Registro Disciplinar' ? 'selected' : '' }}>Registro Disciplinar</option>
                                    <option value="Nota NAI" {{ old('tipo', $registro->tipo) == 'Nota NAI' ? 'selected' : '' }}>Nota NAI</option>
                                    <option value="Registro Pedagogico" {{ old('tipo', $registro->tipo) == 'Registro Pedagogico' ? 'selected' : '' }}>Registro Pedagógico</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
                                <textarea name="descricao" 
                                          id="descricao" 
                                          rows="4"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                          required>{{ old('descricao', $registro->descricao) }}</textarea>
                            </div>

                            <div>
                                <label for="encaminhado_para" class="block text-sm font-medium text-gray-700">Encaminhar para</label>
                                <select name="encaminhado_para" 
                                        id="encaminhado_para" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                        required>
                                    @foreach($setores as $setor)
                                        <option value="{{ $setor->id }}" {{ old('encaminhado_para', $registro->setor_id) == $setor->id ? 'selected' : '' }}>
                                            {{ $setor->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Atualizar Registro
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>