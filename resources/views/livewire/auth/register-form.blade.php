<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    @livewireStyles
</head>
<body>
    <div class="container mt-5">
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
                        <label for="name">Nome:</label>
                        <input type="text" class="form-control" id="name" wire:model.defer="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" class="form-control" id="email" wire:model.defer="email" required>
                    </div>

                    <div class="form-group">
                        <label for="cpf">CPF:</label>
                        <input type="text" 
                               class="form-control" 
                               id="cpf" 
                               wire:model.defer="cpf" 
                               required 
                               maxlength="14"
                               placeholder="000.000.000-00">
                    </div>

                    <div class="form-group">
                        <label for="tipo_usuario">Tipo:</label>
                        <select class="form-control" id="tipo_usuario" wire:model.defer="tipo_usuario" required>
                            <option value="">Selecione</option>
                            <option value="docente">Docente</option>
                            <option value="servidor">Servidor</option>
                            <option value="responsavel">Responsável</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" class="form-control" id="password" wire:model.defer="password" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirme a Senha:</label>
                        <input type="password" class="form-control" id="password_confirmation" wire:model.defer="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading wire:target="register">
                            Processando...
                        </span>
                        <span wire:loading.remove>
                            Cadastrar
                        </span>
                    </button>
                </form>

                @if(app()->environment('local'))
                    <div class="mt-4">
                        <pre>{{ print_r($errors->all(), true) }}</pre>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @livewireScripts
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const cpfInput = document.getElementById('cpf');
        if (cpfInput) {
            cpfInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.slice(0, 11);
                
                if (value.length > 9) {
                    value = value.replace(/^(\d{3})(\d{3})(\d{3})(\d{1,2}).*/, '$1.$2.$3-$4');
                } else if (value.length > 6) {
                    value = value.replace(/^(\d{3})(\d{3})(\d{1,3}).*/, '$1.$2.$3');
                } else if (value.length > 3) {
                    value = value.replace(/^(\d{3})(\d{1,3}).*/, '$1.$2');
                }
                
                e.target.value = value;
            });
        }
    });
    </script>
</body>
</html>