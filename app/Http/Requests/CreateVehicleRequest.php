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
}
