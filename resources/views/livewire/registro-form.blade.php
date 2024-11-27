<div>
    <form wire:submit="salvar">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Curso</label>
                <select wire:model.live="curso_id" class="w-full px-3 py-2 border rounded-lg">
                    <option value="">Selecione um curso</option>
                    @foreach($cursos as $curso)
                        <option value="{{ $curso->id }}">{{ $curso->nome }}</option>
                    @endforeach
                </select>
                @error('curso_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Turma</label>
                <select wire:model.live="turma_id" class="w-full px-3 py-2 border rounded-lg" 
                    {{ empty($turmas) ? 'disabled' : '' }}>
                    <option value="">Selecione uma turma</option>
                    @foreach($turmas as $turma)
                        <option value="{{ $turma->id }}">{{ $turma->nome }}</option>
                    @endforeach
                </select>
                @error('turma_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Aluno</label>
                <select wire:model="aluno_id" class="w-full px-3 py-2 border rounded-lg"
                    {{ empty($alunos) ? 'disabled' : '' }}>
                    <option value="">Selecione um aluno</option>
                    @foreach($alunos as $aluno)
                        <option value="{{ $aluno->id }}">{{ $aluno->nome }}</option>
                    @endforeach
                </select>
                @error('aluno_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Data</label>
                <input type="date" wire:model="data" class="w-full px-3 py-2 border rounded-lg" required>
                @error('data') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tipo</label>
                <select wire:model="tipo" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="Advertência">Advertência</option>
                    <option value="Registro Disciplinar">Registro Disciplinar</option>
                    <option value="Nota NAI">Nota NAI</option>
                    <option value="Registro Pedagogico">Registro Pedagógico</option>
                </select>
                @error('tipo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Encaminhar para</label>
            <select wire:model="encaminhado_para" class="w-full px-3 py-2 border rounded-lg" required>
                <option value="">Selecione um setor</option>
                @foreach($setores as $setor)
                    <option value="{{ $setor->id }}">{{ $setor->nome }}</option>
                @endforeach
            </select>
            @error('encaminhado_para') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Descrição</label>
            <textarea wire:model="descricao" class="w-full px-3 py-2 border rounded-lg" rows="4" required></textarea>
            @error('descricao') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <div class="flex items-center">
                <input type="checkbox" wire:model.live="agendamento" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label class="ml-2 block text-sm text-gray-700">Criar agendamento</label>
            </div>
        </div>

        @if($agendamento)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Data do Agendamento</label>
                    <input type="date" wire:model="data_agendamento" class="w-full px-3 py-2 border rounded-lg">
                    @error('data_agendamento') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Hora do Agendamento</label>
                    <input type="time" wire:model="hora_agendamento" class="w-full px-3 py-2 border rounded-lg">
                    @error('hora_agendamento') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Participantes</label>
                    <input type="text" wire:model="participantes" class="w-full px-3 py-2 border rounded-lg">
                    @error('participantes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
    <label class="block text-gray-700 text-sm font-bold mb-2">Local</label>
    <select wire:model="local_id" class="w-full px-3 py-2 border rounded-lg">
        <option value="">Selecione um local</option>
        @foreach($locais as $local)
            <option value="{{ $local->id }}">
                {{ $local->predio->nome ?? 'Prédio não definido' }} - 
                            {{ $local->tipo_local }} {{ $local->numero }}
                        </option>
                    @endforeach
                </select>
                @error('local_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            </div>
        @endif

        <div class="mt-6 flex justify-end">
            <button type="submit" class="btn btn-primary">
                Criar Registro
            </button>
        </div>
    </form>
</div>