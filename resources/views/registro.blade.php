<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Simples</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Cadastro Simples</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <!-- Mensagem de sucesso -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('registro.store') }}">
    @csrf

    <div class="form-group">
        <label for="nome">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" required>
    </div>

    <div class="form-group">
        <label for="email">E-mail:</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>

    <div class="form-group">
        <label for="cpf">CPF:</label>
        <input type="text" class="form-control" id="cpf" name="cpf" required>
    </div>

    <div class="form-group">
        <label for="password">Senha:</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>

    <div class="form-group">
        <label for="type">Tipo:</label>
        <select class="form-control" id="type" name="type" required>
            <option>Selecione</option>
            <option value="docente">Docente</option>
            <option value="servidor">Servidor</option>
        </select>
    </div>

    <!-- Campos que aparecem apenas se type = docente -->
    <div id="docente-fields" style="display:none;">
        <div class="form-group">
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento">
        </div>

        <div class="form-group">
            <label for="departamento_id">Departamento:</label>
            <select class="form-control" id="departamento_id" name="departamento_id">
                @foreach ($departamentos as $departamento)
                    <option value="{{ $departamento->id }}">{{ $departamento->nome }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Campos que aparecem apenas se type = servidor -->
    <div id="servidor-fields" style="display:none;">
        <div class="form-group">
            <label for="setor_id">Setor:</label>
            <select class="form-control" id="setor_id" name="setor_id">
                @foreach ($setores as $setor)
                    <option value="{{ $setor->id }}">{{ $setor->nome }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
</form>

<script>
    document.getElementById('type').addEventListener('change', function () {
        var type = this.value;
        document.getElementById('docente-fields').style.display = (type === 'docente') ? 'block' : 'none';
        document.getElementById('servidor-fields').style.display = (type === 'servidor') ? 'block' : 'none';
    });
</script>

</div>

</body>
</html>
