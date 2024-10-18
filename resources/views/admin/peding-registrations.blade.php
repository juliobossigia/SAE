@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Cadastros Pendentes') }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($registrosPendentes->isEmpty())
                        <div class="alert alert-info" role="alert">
                            Não há cadastros pendentes no momento.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>CPF</th>
                                        <th>Tipo</th>
                                        <th>Data do Cadastro</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registrosPendentes as $registro)
                                        <tr>
                                            <td>{{ $registro->nome }}</td>
                                            <td>{{ $registro->email }}</td>
                                            <td>{{ $registro->cpf }}</td>
                                            <td>{{ ucfirst($registro->type) }}</td>
                                            <td>{{ $registro->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                              <h2>AQUI VAI FICA APROVAR OU NEGAR</h2>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection