<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePerguntaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // O evento vem da URL (/eventos/{id}/perguntas), então injetamos no validador.
    protected function prepareForValidation(): void
    {
        $this->merge(['evento_id' => $this->route('id')]);
    }

    public function rules(): array
    {
        return [
            'texto'     => 'required|string|min:10|max:255',
            'evento_id' => 'required|exists:eventos,id',
        ];
    }

    public function messages(): array
    {
        return [
            'texto.required' => 'A pergunta não pode estar em branco.',
            'texto.min'      => 'A pergunta precisa ter pelo menos :min caracteres.',
            'texto.max'      => 'A pergunta pode ter no máximo :max caracteres.',
        ];
    }
}
