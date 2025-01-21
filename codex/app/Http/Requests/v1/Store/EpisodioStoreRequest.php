<?php

namespace App\Http\Requests\v1\Store;

use Illuminate\Foundation\Http\FormRequest;

class EpisodioStoreRequest extends FormRequest
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
            "idSerieTv" => "required|integer",
            "titolo" => "required|string",
            "descrizione" => "required|string",
            "numeroStagione" => "required|integer",
            "NumeroEpisodio" => "required|integer",
            "durata" => "required|integer",
            "anno" => "required|integer"
        ];
    }
}
