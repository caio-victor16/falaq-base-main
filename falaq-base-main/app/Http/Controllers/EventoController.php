<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Pergunta;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    /**
     * Exibe os detalhes do evento e suas perguntas paginadas.
     */
    public function show(Evento $evento)
    {
        // 1. Filtra as perguntas do evento atual
        // 2. Ordena pelas mais recentes (latest)
        // 3. Pagina de 10 em 10 (paginate(10))
        $perguntas = Pergunta::where('evento_id', $evento->id)
            ->latest()
            ->paginate(10);

        return view('eventos.show', compact('evento', 'perguntas'));
    }
}