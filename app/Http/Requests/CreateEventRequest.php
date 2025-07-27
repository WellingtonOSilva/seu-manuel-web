<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle' => ['required'],
            'event' => ['required', 'string'],
            'date' => ['required', 'date'],
            'cost' => ['required', 'numeric'],
            'km' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'vehicle.required' => 'O veículo é obrigatório.',
            'vehicle.exists' => 'Veículo inválido.',
            'event.required' => 'O tipo de evento é obrigatório.',
            'date.required' => 'A data é obrigatória.',
            'date.date' => 'A data informada não é válida.',
            'km.numeric' => 'Quilometragem deve ser um número.',
            'cost.numeric' => 'Custo deve ser um número.'
        ];
    }
}
