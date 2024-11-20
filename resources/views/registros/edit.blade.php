<x-app-layout>
    <div class="container" style="margin-top:-50px;">
        <h1>Editar Registro</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('registros.update', $registro->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="data">Data:</label>
                <input type="date" id="data" name="data" value="{{ old('data', $registro->data) }}" required>
            </div>
            <div class="form-group">
                <label for="aluno">Aluno:</label>
                <select id="aluno" name="aluno_id">
                    <option value="">Selecione um Aluno</option>
                    @foreach($alunos as $aluno)
                    <option value="{{ $aluno->id }}" {{ old('aluno_id', $registro->aluno_id) == $aluno->id ? 'selected' : '' }}>{{ $aluno->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="turma">Turma:</label>
                <select id="turma" name="turma_id">
                    <option value="">Selecione uma Turma</option>
                    @foreach($turmas as $turma)
                    <option value="{{ $turma->id }}" {{ old('turma_id', $registro->turma_id) == $turma->id ? 'selected' : '' }}>{{ $turma->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="tipo">Tipo:</label>
                <select id="tipo" name="tipo" required>
                    <option value="" disabled>Selecione o tipo</option>
                    <option value="Advertência" {{ old('tipo', $registro->tipo) == 'Advertência' ? 'selected' : '' }}>Advertência</option>
                    <option value="Elogio" {{ old('tipo', $registro->tipo) == 'Elogio' ? 'selected' : '' }}>Elogio</option>
                    <option value="Registro Disciplinar" {{ old('tipo', $registro->tipo) == 'Registro Disciplinar' ? 'selected' : '' }}>Registro Disciplinar</option>
                </select>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" required>{{ old('descricao', $registro->descricao) }}</textarea>
            </div>
            <div class="form-group">
                <label for="encaminhado_para">Encaminhado Para:</label>
                <input type="text" id="encaminhado_para" name="encaminhado_para" value="{{ old('encaminhado_para', $registro->encaminhado_para) }}" required>
            </div>
            <div class="form-group registro">
                <label for="agendamento">Realizar Agendamento:</label>
                <div class="radio-group">
                    <input type="radio" name="agendamento" id="agendamento_sim" value="1" {{ old('agendamento', $registro->agendamento) == '1' ? 'checked' : '' }}>
                    <label for="agendamento_sim">Sim</label>

                    <input type="radio" name="agendamento" id="agendamento_nao" value="0" {{ old('agendamento', $registro->agendamento) == '0' ? 'checked' : '' }}>
                    <label for="agendamento_nao">Não</label>
                </div>
            </div>

            <div class="form-group registro form-agendamento {{ old('agendamento') == '1' ? 'show' : 'd-none' }}">
                <label for="participantes">Participantes:</label>
                <input type="text"
                    class="form-control"
                    name="participantes"
                    id="participantes"
                    value="{{ old('participantes') }}">
            </div>

            <div class="form-group registro form-agendamento {{ old('agendamento') == '1' ? 'show' : 'd-none' }}">
                <label for="dataAgendamento">Data:</label>
                <input type="date"
                    class="form-control"
                    name="data_agendamento"
                    id="dataAgendamento"
                    value="{{ old('data_agendamento') }}">
            </div>

            <div class="form-group registro form-agendamento {{ old('agendamento') == '1' ? 'show' : 'd-none' }}">
                <label for="horaAgendamento">Hora:</label>
                <input type="time"
                    class="form-control"
                    name="hora_agendamento"
                    id="horaAgendamento"
                    value="{{ old('hora_agendamento') }}">
            </div>

            <div class="form-group registro form-agendamento {{ old('agendamento') == '1' ? 'show' : 'd-none' }}">
                <label for="local_id">Local:</label>
                <select name="local_id"
                    id="local_id"
                    class="form-control">
                    <option value="">Selecione um local</option>
                    @foreach($locais as $local)
                    <option value="{{ $local->id }}" {{ old('local_id') == $local->id ? 'selected' : '' }}>
                        {{ $local->nome }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Atualizar Registro</button>
            </div>
        </form>
    </div>
</x-app-layout>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const agendamentoCheckbox = document.querySelector('input[name="agendamento"]');
        const agendamentoFields = document.querySelectorAll('.form-agendamento');

        if (agendamentoCheckbox) {
            agendamentoCheckbox.addEventListener('change', function() {
                agendamentoFields.forEach(field => {
                    if (this.checked) {
                        field.classList.remove('d-none');
                        field.classList.add('show');
                    } else {
                        field.classList.add('d-none');
                        field.classList.remove('show');
                    }
                });
            });
        }
    });
</script>
@endsection