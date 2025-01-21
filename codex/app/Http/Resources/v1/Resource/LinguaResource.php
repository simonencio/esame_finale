<?php

namespace App\Http\Resources\v1\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinguaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        // return parent::toArray($request);
        return $this->getCampi();
    }
    protected function getCampi()
    {
        return [
            'idLingua' => $this->idLingua,
            'nome' => $this->nome,
            'abbreviazione' => $this->abbreviazione
        ];
    }
}
