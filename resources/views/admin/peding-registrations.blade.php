<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastros Pendentes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Cadastros Pendentes</h3>
                        <i class="fas fa-users"></i> <!-- Ícone de usuários -->
                    </div>

                    <div class="card-body">
                        <!-- Mensagens de sucesso/erro -->
                        <div class="alert alert-success" role="alert" style="display: none;" id="success-message">
                            {{ session('success') }}
                        </div>

                        <div class="alert alert-danger" role="alert" style="display: none;" id="error-message">
                            {{ session('error') }}
                        </div>

                        <!-- Exibindo tabela com cadastros pendentes -->
                        <div class="table-responsive" id="records-table">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>CPF</th>
                                        <th>Tipo</th>
                                        <th>Data do Cadastro</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Iterando sobre os cadastros pendentes -->
                                    @foreach($registrosPendentes as $registro)
                                    <tr>
                                        <td>{{ $registro->nome }}</td>
                                        <td>{{ $registro->email }}</td>
                                        <td>{{ $registro->cpf }}</td>
                                        <td>{{ ucfirst($registro->type) }}</td>
                                        <td>{{ $registro->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('registro.approve', $registro->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i> Aprovar
                                                </button>
                                            </form>
                                            <!-- Botão Rejeitar -->
                                            <form action="{{ route('registro.reject', $registro->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times"></i> Negar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>