<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ExistsMongo;
class CalculatePriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'addresses' => 'required|array|min:2',
            'addresses.*.country' => ['required', 'string', new ExistsMongo( 'country')],
            'addresses.*.zip' => ['required', 'string', new ExistsMongo( 'zipCode')],
            'addresses.*.city' => ['required', 'string', new ExistsMongo( 'name')],
        ];
    }
}
