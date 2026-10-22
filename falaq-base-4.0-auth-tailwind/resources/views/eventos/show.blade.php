@extends('layouts.app')

@section('title', $evento->titulo . ' — FalaQ')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-12 gap-6">

    <!-- Formulário de envio de Pergunta (TICKETS #007 e #008) -->
    <div class="md:col-span-5">
        <div class="bg-[#1a1d27] border border-[#2e3347] rounded-xl shadow-sm p-5">
            <h4 class="text-xl font-bold mb-4">💬 Faça sua Pergunta</h4>

            <form action="{{ route('eventos.perguntas.store', $evento->id) }}" method="POST">
                @csrf

                <label for="texto" class="block text-sm text-gray-400 mb-2">Texto da Pergunta</label>

                <textarea name="texto" id="texto" rows="4"
                          placeholder="Digite sua dúvida ou comentário para o palestrante..."
                          class="w-full p-3 rounded-md bg-gray-900 text-white border focus:outline-none focus:ring-2 focus:ring-blue-500 @error('texto') border-red-500 @else border-gray-600 @enderror">{{ old('texto') }}</textarea>

                @error('texto')
                    <p class="text-red-500 text-sm font-semibold mt-1">{{ $message }}</p>
                @enderror

                <button type="submit"
                        class="mt-4 w-full bg-blue-600 text-white px-4 py-2 rounded-md font-bold hover:bg-blue-700 transition">
                    Enviar Pergunta
                </button>
            </form>
        </div>
    </div>

    <!-- Mural de Perguntas -->
    <div class="md:col-span-7">
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-xl font-bold">📋 Perguntas do Evento</h4>
            <span class="text-gray-400 text-sm">Total no Banco: {{ $evento->perguntas->count() }}</span>
        </div>

        @forelse($perguntas as $pergunta)
            <div class="mb-4 p-4 bg-[#1a1d27] border border-[#2e3347] rounded-2xl rounded-tl-none shadow-sm">
                <p class="text-lg text-white mb-2">{{ $pergunta->texto }}</p>
                <div class="flex justify-between items-center text-gray-400 text-sm">
                    <span>Status:
                        <span class="bg-green-600 text-white text-xs px-2 py-1 rounded-full">{{ $pergunta->status }}</span>
                    </span>
                    <span>{{ $pergunta->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        @empty
            <div class="text-center p-6 bg-[#1a1d27] border border-[#2e3347] rounded-xl text-gray-300">
                Nenhuma pergunta enviada ainda. Seja o primeiro!
            </div>
        @endforelse

        @if(method_exists($perguntas, 'links'))
            <div class="flex justify-center mt-6">
                {{ $perguntas->links() }}
            </div>
        @endif
    </div>
</div>

    @foreach ($evento->perguntas as $pergunta)
            <div>
                <p>{{ $pergunta->texto }}</p>

                <form action="{{ route('perguntas.votar', $perguntas) }}" method="POST">
            @csrf
                <button type="submit">
                    {{ $pergunta->votos->contains(auth()->id()) ? 'Remover voto' : 'Votar' }}
                    ({{ $pergunta->votos->count() }})
                </button>
                </form>
    </div>
        @endforeach

@foreach ($evento->perguntas as $pergunta)
    <div class="card">
        <p>{{ $pergunta->texto }}</p>

        <span>{{ $pergunta->votos_count }} {{ Str::plural('voto', $pergunta->votos_count) }}</span>

        @auth
            <form action="{{ route('perguntas.votar', $pergunta) }}" method="POST">
                @csrf
                <button
                    type="submit"
                    class="{{ $pergunta->user_votou ? 'bg-blue-600 text-white font-bold' : 'bg-gray-200 text-gray-800' }}"
                    title="{{ $pergunta->user_votou ? 'Clique para remover seu voto' : 'Clique para votar' }}"
                >
                    {{ $pergunta->user_votou ? '▲ Votado (remover)' : '△ Upvote' }}
                </button>
            </form>
        @endauth
    </div>
@endforeach
@endsection
