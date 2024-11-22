<x-app-layout>
    <div class="container" style="margin-top:-50px;">
        <h1>Criar Novo Registro</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.registros.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="data">Data</label>
                <input type="date" name="data" id="data" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="aluno_id">Aluno</label>
                <select name="aluno_id" id="aluno_id" class="form-control">
                    <option value="">Selecione um aluno</option>
                    @foreach($alunos as $aluno)
                        <option value="{{ $aluno->id }}">{{ $aluno->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="turma_id">Turma</label>
                <select name="turma_id" id="turma_id" class="form-control">
                    <option value="">Selecione uma turma</option>
                    @foreach($turmas as $turma)
                        <option value="{{ $turma->id }}">{{ $turma->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tipo">Tipo</label>
                <select name="tipo" id="tipo" class="form-control" required>
                    <option value="Advertência">Advertência</option>
                    <option value="Registro Disciplinar">Registro Disciplinar</option>
                    <option value="Nota NAI">Nota NAI</option>
                    <option value="Registro Pedagogico">Registro Pedagógico</option>
                </select>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea name="descricao" id="descricao" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="encaminhado_para">Encaminhar para</label>
                <select name="encaminhado_para" id="encaminhado_para" class="form-control" required>
                    @foreach($setores as $setor)
                        <option value="{{ $setor->id }}">{{ $setor->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="agendamento" id="agendamento">
                    Agendar atendimento?
                </label>
            </div>

            <div id="campos-agendamento" style="display: none;">
                <div class="form-group">
                    <label for="data_agendamento">Data do Agendamento</label>
                    <input type="date" name="data_agendamento" id="data_agendamento" class="form-control">
                </div>

                <div class="form-group">
                    <label for="hora_agendamento">Hora do Agendamento</label>
                    <input type="time" name="hora_agendamento" id="hora_agendamento" class="form-control">
                </div>

                <div class="form-group">
                    <label for="participantes">Participantes</label>
                    <input type="text" name="participantes" id="participantes" class="form-control">
                </div>

                <div class="form-group">
                    <label for="local_id">Local</label>
                    <select name="local_id" id="local_id" class="form-control">
                        <option value="">Selecione um local</option>
                        @foreach($locais as $local)
                            <option value="{{ $local->id }}">{{ $local->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Criar Registro</button>
            <a href="{{ route('admin.registros.index') }}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>

    @push('scripts')
    <script>
        document.getElementById('agendamento').addEventListener('change', function() {
            const camposAgendamento = document.getElementById('campos-agendamento');
            camposAgendamento.style.display = this.checked ? 'block' : 'none';
        });
    </script>
    @endpush
</x-app-layout>
