@extends('layout')

@section('content')
    <h1>Adicionar Servidor</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.servidores.store') }}" method="POST">
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
            <label for="setor_id">Setor:</label>
            <select name="setor_id" id="setor" required>
                <option value="">Selecione um setor</option>
                @foreach($setores as $setor)
                    <option value="{{ $setor->id }}" {{ old('setor_id') == $setor->id ? 'selected' : '' }}>
                        {{ $setor->nome }}
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
            <a href="{{ route('admin.servidores.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    // Máscara para CPF
    $(document).ready(function(){
        $('#cpf').mask('000.000.000-00', {reverse: true});
    });
</script>
@endpush
