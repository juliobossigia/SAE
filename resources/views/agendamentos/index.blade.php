@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Agendamentos</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Data</th>
                <th>Hora</th>
                <th>Local</th>
                <th>Participantes</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agendamentos as $agendamento)
            <tr>
                <td>{{ $agendamento->data_agendamento->format('d/m/Y') }}</td>
                <td>{{ $agendamento->hora_agendamento }}</td>
                <td>{{ $agendamento->local->nome ?? 'Não definido' }}</td>
                <td>{{ $agendamento->participantes }}</td>
                <td>{{ $agendamento->status }}</td>
                <td>
                    <a href="{{ route('agendamentos.show', $agendamento) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('agendamentos.edit', $agendamento) }}" class="btn btn-sm btn-primary">Editar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $agendamentos->links() }}
</div>
@endsection