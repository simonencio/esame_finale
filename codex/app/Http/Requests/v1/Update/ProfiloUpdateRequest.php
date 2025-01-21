<?php

namespace App\Http\Requests\v1\Update;

use App\Helpers\AppHelpers;
use App\Http\Requests\v1\Store\ProfiloStoreRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProfiloUpdateRequest extends ProfiloStoreRequest
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
        $rules = parent::rules();
        return AppHelpers::aggiornaRegoleHelper($rules);
    }
}
