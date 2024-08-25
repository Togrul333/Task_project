<?php

namespace App\Rules;

use App\Models\City;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class UniqueUserName implements Rule
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
        return   !User::where($this->field, $value)->exists();
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return "The selected {$this->field} already exists.";
    }
}
