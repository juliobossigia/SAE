<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vincular Alunos ao Responsável
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Filtros -->
                    <div class="mb-6 flex gap-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Filtrar por Curso
                            </label>
                            <select id="curso_filter" class="w-full px-3 py-2 border rounded-lg">
                                <option value="">Todos os Cursos</option>
                                @foreach($cursos as $curso)
                                    <option value="{{ $curso->id }}" 
                                        {{ request('curso_id') == $curso->id ? 'selected' : '' }}>
                                        {{ $curso->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex-1">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Buscar Aluno
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       id="search_filter"
                                       value="{{ request('search') }}"
                                       class="w-full px-3 py-2 border rounded-lg pr-10"
                                       placeholder="Nome do aluno...">
                                <button type="button" onclick="filterAlunos()" class="absolute right-2 top-2">
                                    🔍
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de Alunos em um formulário separado -->
                    <form action="{{ route('admin.aluno-responsavel.store') }}" method="POST">
                        @csrf
                        
                        <!-- Seleção do Responsável -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Selecione o Responsável
                            </label>
                            <select name="responsavel_id" required class="w-full px-3 py-2 border rounded-lg">
                                <option value="">Selecione...</option>
                                @foreach($responsaveis as $responsavel)
                                    <option value="{{ $responsavel->id }}">
                                        {{ $responsavel->nome }} - {{ $responsavel->cpf }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Lista de Alunos -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Selecione os Alunos
                            </label>
                            <div class="border rounded-lg p-4 max-h-96 overflow-y-auto">
                                @forelse($alunos as $aluno)
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" 
                                               name="aluno_ids[]" 
                                               value="{{ $aluno->id }}"
                                               onchange="checkSelectedAlunos()"
                                               class="mr-2">
                                        <label>
                                            {{ $aluno->nome }} - {{ $aluno->matricula }}
                                            <span class="text-gray-500 text-sm">
                                                ({{ $aluno->curso->nome }})
                                            </span>
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-gray-500">Nenhum aluno encontrado.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Botão Submit fixo na parte inferior -->
                        <div class="fixed bottom-4 right-4 z-50">
                            <button id="submitButton" 
                                    type="submit" 
                                    style="display: none;"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg">
                                Vincular Alunos
                            </button>
                        </div>
                    </form>

                    <!-- Paginação -->
                    <div class="mt-4 mb-16">
                        {{ $alunos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Adicione este script no final do seu layout, antes do </body> -->
    <script>
        function checkSelectedAlunos() {
            const checkboxes = document.querySelectorAll('input[name="aluno_ids[]"]');
            const submitButton = document.getElementById('submitButton');
            const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
            
            submitButton.style.display = anyChecked ? 'block' : 'none';
        }

        // Executar verificação inicial
        document.addEventListener('DOMContentLoaded', checkSelectedAlunos);

        // Adicionar listener para todos os checkboxes
        document.querySelectorAll('input[name="aluno_ids[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', checkSelectedAlunos);
        });

        function filterAlunos() {
            const cursoId = document.getElementById('curso_filter').value;
            const search = document.getElementById('search_filter').value;
            const alunosContainer = document.querySelector('.overflow-y-auto');
            
            // Manter os valores selecionados
            const selectedAlunos = Array.from(document.querySelectorAll('input[name="aluno_ids[]"]:checked'))
                .map(checkbox => checkbox.value);
            
            fetch(`{{ route('admin.aluno-responsavel.create') }}?curso_id=${cursoId}&search=${search}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newAlunosList = doc.querySelector('.overflow-y-auto').innerHTML;
                
                alunosContainer.innerHTML = newAlunosList;
                
                // Restaurar seleções anteriores
                selectedAlunos.forEach(alunoId => {
                    const checkbox = document.querySelector(`input[name="aluno_ids[]"][value="${alunoId}"]`);
                    if (checkbox) checkbox.checked = true;
                });
                
                // Reativar os eventos nos checkboxes
                document.querySelectorAll('input[name="aluno_ids[]"]').forEach(checkbox => {
                    checkbox.addEventListener('change', checkSelectedAlunos);
                });
                
                checkSelectedAlunos();
            });
        }

        // Adicionar eventos para filtros
        document.getElementById('curso_filter').addEventListener('change', filterAlunos);
        document.getElementById('search_filter').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') filterAlunos();
        });
    </script>
</x-app-layout>