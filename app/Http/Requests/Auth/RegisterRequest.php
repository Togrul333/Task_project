<?php

namespace App\Http\Requests\Auth;

use App\Rules\UniqueUserName;
use Dflydev\DotAccessData\Data;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'username'     =>  ['required', 'string', new UniqueUserName( 'username')],
        ];
    }
}
