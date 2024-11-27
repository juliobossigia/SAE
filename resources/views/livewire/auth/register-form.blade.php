<div class="container mt-5" x-data="{ 
    tipoUsuario: @entangle('tipo_usuario').defer, 
    isCoordenador: @entangle('is_coordenador').defer 
}">
    <div class="card">
        <div class="card-header">
            <h2>Cadastro de Usuário</h2>
        </div>
        
        <div class="card-body">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form wire:submit.prevent="register">
                <div class="form-group">
                    <label for="name">Nome Completo:</label>
                    <input type="text" class="form-control" id="name" wire:model.defer="name" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" class="form-control" id="email" wire:model.defer="email" required>
                </div>

                <div class="form-group">
                    <label for="cpf">CPF:</label>
                    <input type="text" class="form-control" id="cpf" wire:model.defer="cpf" required>
                </div>

                <div class="form-group">
                    <label for="password">Senha:</label>
                    <input type="password" class="form-control" id="password" wire:model.defer="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Senha:</label>
                    <input type="password" class="form-control" id="password_confirmation" wire:model.defer="password_confirmation" required>
                </div>

                <div class="form-group">
                    <label for="tipo_usuario">Tipo de Usuário:</label>
                    <select 
                        class="form-control" 
                        id="tipo_usuario" 
                        wire:model.defer="tipo_usuario"
                        x-model="tipoUsuario"
                        @change="$wire.set('tipo_usuario', $event.target.value)"
                        required
                    >
                        <option value="">Selecione</option>
                        <option value="docente">Docente</option>
                        <option value="servidor">Servidor</option>
                        <option value="responsavel">Responsável</option>
                    </select>
                </div>

                <div class="mt-2 text-muted">
                    <small>Alpine tipoUsuario: <span x-text="tipoUsuario"></span></small><br>
                    <small>Livewire tipo_usuario: {{ $tipo_usuario }}</small>
                </div>

                <div x-show="tipoUsuario === 'docente'">
                    <div class="form-group">
                        <label for="departamento_id">Departamento:</label>
                        <select 
                            class="form-control" 
                            id="departamento_id" 
                            wire:model="departamento_id" 
                            :required="tipoUsuario === 'docente'"
                        >
                            <option value="">Selecione o Departamento</option>
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento->id }}">{{ $departamento->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="data_nascimento">Data de Nascimento:</label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="data_nascimento" 
                            wire:model.defer="data_nascimento"
                            :required="tipoUsuario === 'docente'"
                        >
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_coordenador" wire:model="is_coordenador">
                            <label class="form-check-label" for="is_coordenador">É Coordenador?</label>
                        </div>
                    </div>

                    @if($is_coordenador)
                        <div class="form-group">
                            <label for="curso_id">Curso:</label>
                            <select class="form-control" id="curso_id" wire:model="curso_id" required>
                                <option value="">Selecione o Curso</option>
                                @foreach($cursos as $curso)
                                    <option value="{{ $curso->id }}">{{ $curso->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>

                <div x-show="tipoUsuario === 'servidor'">
                    <div class="form-group">
                        <label for="setor_id">Setor:</label>
                        <select 
                            class="form-control" 
                            id="setor_id" 
                            wire:model.defer="setor_id"
                            :required="tipoUsuario === 'servidor'"
                        >
                            <option value="">Selecione o Setor</option>
                            @foreach($setores as $setor)
                                <option value="{{ $setor->id }}">{{ $setor->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mt-2 text-muted">
                        <small>Tipo usuário: {{ $tipo_usuario }}</small><br>
                        <small>Setor selecionado: {{ $setor_id }}</small><br>
                        <small>Setores disponíveis: {{ count($setores) }}</small>
                    </div>
                </div>

                <button 
                    type="submit" 
                    class="btn btn-primary" 
                    wire:loading.attr="disabled"
                    @click="console.log('Botão clicado')"
                >
                    <span wire:loading wire:target="register">Cadastrando...</span>
                    <span wire:loading.remove>Cadastrar</span>
                </button>
            </form>
        </div>
    </div>
</div>