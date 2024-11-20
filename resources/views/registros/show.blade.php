<x-app-layout>
    <div class="container" style="margin-top:-50px;">
        <h1>Detalhes do Registro</h1>

        <div class="registro-details">
            <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($registro->data)->format('d/m/Y') }}</p>
            <p><strong>Aluno:</strong> {{ $registro->aluno ? $registro->aluno->nome : 'N/A' }}</p>
            <p><strong>Turma:</strong> {{ $registro->turma ? $registro->turma->nome : 'N/A' }}</p>
            <p><strong>Tipo:</strong> {{ $registro->tipo }}</p>
            <p><strong>Descrição:</strong> {{ $registro->descricao }}</p>
            <p><strong>Encaminhado Para:</strong> {{ $registro->encaminhado_para }}</p>
            @if($registro->agendamento)
                <p><strong>Data Agendamento:</strong> {{ \Carbon\Carbon::parse($registro->data_agendamento)->format('d/m/Y') }}</p>
                <p><strong>Hora Agendamento:</strong> {{ \Carbon\Carbon::parse($registro->hora_agendamento)->format('H:i') }}</p>
                <p><strong>Participantes:</strong> {{ $registro->participantes }}</p>
                <p><strong>Local Agendamento:</strong> {{ $registro->local_agendamento }}</p>
            @endif
            <p><strong>Criado Por:</strong> {{ $registro->criador->name }}</p>
        </div>

        <a href="{{ route('registros.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
</x-app-layout>
