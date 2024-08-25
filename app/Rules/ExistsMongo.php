<?php

namespace App\Rules;

use App\Models\City;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class ExistsMongo implements Rule
{
    protected $field;

    public function __construct( $field)
    {
        $this->field = $field;
    }

    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value): bool
    {
        return   City::where($this->field, $value)->exists();
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return "The selected {$this->field} attribute does not exist.";
    }
}
