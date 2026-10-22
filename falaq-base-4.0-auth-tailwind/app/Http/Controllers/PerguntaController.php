<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pergunta;

class PerguntaController extends Controller
{
    // ... demais métodos

    public function votar(Pergunta $pergunta)
    {
        $resultado = $pergunta->votos()->toggle(auth()->id());

        $mensagem = count($resultado['attached']) > 0
            ? 'Voto registrado com sucesso!'
            : 'Voto removido.';

        return back()->with('status', $mensagem);
    }
}
