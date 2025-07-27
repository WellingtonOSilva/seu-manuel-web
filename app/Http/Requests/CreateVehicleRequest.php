<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use function Pest\version;


/**
 * @property string $licensePlate
 * @property string $brand
 * @property string $model
 * @property string $version
 * @property int $year
 * @property bool $isNew
 * @property int|null $km
 * @property mixed $ownerId
 */
class CreateVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'ownerId' => auth()->id(),
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'licensePlate' => [
                'required',
                'string',
                'max:7',
                'regex:/^[A-Z]{3}[0-9]{4}$|^[A-Z]{3}[0-9][A-Z][0-9]{2}$/i',
            ],
            'brand' => ['required', 'string'],
            'model' => ['required', 'string'],
            'version' => ['required', 'string'],
            'year' => ['required', 'numeric'],
            'isNew' => ['required', 'boolean'],
            'km' => ['required_if:isNew,0', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'licensePlate.required' => 'A placa do veículo é obrigatória.',
            'licensePlate.string' => 'A placa do veículo deve ser um texto.',
            'licensePlate.max' => 'A placa do veículo deve ter no máximo 7 caracteres.',
            'licensePlate.regex' => 'A placa do veículo deve estar no formato válido (ex: ABC1234 ou ABC1D23).',

            'brand.required' => 'A marca do veículo é obrigatória.',
            'brand.string' => 'A marca do veículo deve ser um texto.',

            'model.required' => 'O modelo do veículo é obrigatório.',
            'model.string' => 'O modelo do veículo deve ser um texto.',

            'version.required' => 'A versão do veículo é obrigatória.',
            'version.string' => 'A versão do veículo deve ser um texto.',

            'year.required' => 'O ano do veículo é obrigatório.',
            'year.numeric' => 'O ano do veículo deve ser um número.',

            'isNew.required' => 'É necessário informar se o veículo é novo.',
            'isNew.boolean' => 'O campo "é novo" deve ser verdadeiro ou falso.',

            'km.required_if' => 'A quilometragem é obrigatória para veículos usados.',
            'km.numeric' => 'A quilometragem deve ser um número.',
        ];
    }
}
