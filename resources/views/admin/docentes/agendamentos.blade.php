@extends('layout')

@section('content')
    <h1>Meus Agendamentos</h1>
    
    @if($agendamentos->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Local</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($agendamentos as $agendamento)
                    <tr>
                        <td>{{ $agendamento->data }}</td>
                        <td>{{ $agendamento->horario }}</td>
                        <td>{{ $agendamento->local->nome }}</td>
                        <td>{{ $agendamento->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Nenhum agendamento encontrado.</p>
    @endif
@endsection
