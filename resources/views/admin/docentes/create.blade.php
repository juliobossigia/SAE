@extends('layout')

@section('content')
    <h1>Adicionar Docente</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.docentes.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}" required>
        </div>

        <div class="form-group">
            <label for="password">Senha:</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmar Senha:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <div class="form-group">
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" name="data_nascimento" id="data_nascimento" value="{{ old('data_nascimento') }}" required>
        </div>

        <div class="form-group">
            <label for="departamento_id">Departamento:</label>
            <select name="departamento_id" id="departamento_id" required>
                <option value="">Selecione um departamento</option>
                @foreach($departamentos as $departamento)
                    <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                        {{ $departamento->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="disciplinas">Disciplinas:</label>
            <select name="disciplinas[]" id="disciplinas" multiple>
                @foreach($disciplinas as $disciplina)
                    <option value="{{ $disciplina->id }}" {{ in_array($disciplina->id, old('disciplinas', [])) ? 'selected' : '' }}>
                        {{ $disciplina->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="is_coordenador">É Coordenador?</label>
            <input type="checkbox" name="is_coordenador" id="is_coordenador" value="1" {{ old('is_coordenador') ? 'checked' : '' }}>
        </div>

        <div class="form-group" id="curso_section" style="display: {{ old('is_coordenador', false) ? 'block' : 'none' }};">
            <label for="curso_id">Curso:</label>
            <select name="curso_id" id="curso_id" {{ old('is_coordenador', false) ? 'required' : '' }}>
                <option value="">Selecione um curso</option>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}" {{ old('curso_id') == $curso->id ? 'selected' : '' }}>
                        {{ $curso->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="ativo" {{ old('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                <option value="inativo" {{ old('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('admin.docentes.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $('#cpf').mask('000.000.000-00', {reverse: true});
        
        $('#is_coordenador').change(function(){
            if($(this).is(':checked')) {
                $('#curso_section').show();
                $('#curso_id').prop('required', true);
            } else {
                $('#curso_section').hide();
                $('#curso_id').prop('required', false);
                $('#curso_id').val('');
            }
        });

        // Verificar estado inicial
        if($('#is_coordenador').is(':checked')) {
            $('#curso_section').show();
            $('#curso_id').prop('required', true);
        }
    });
</script>
@endpush
