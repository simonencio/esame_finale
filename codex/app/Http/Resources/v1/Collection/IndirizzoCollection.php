<?php

namespace App\Http\Resources\v1\Collection;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IndirizzoCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        // return parent::toArray($request);
        $tmp = parent::toArray($request);
        $tmp = array_map(array($this, 'getCampi'), $tmp); // $this->getCampi non funziona
        return $tmp;
    }

    protected function getCampi($item)
    {
        return [
            'idIndirizzo' => $item["idIndirizzo"],
            'idTipologiaIndirizzo' => $item["idTipologiaIndirizzo"],
            'idContatto' => $item["idContatto"],
            'nazione' => $item["nazione"],
            'cittadinanza' => $item["cittadinanza"],
            'provincia' => $item["provincia"],
            'citta' => $item["citta"],
            'cap' => $item["cap"],
            'indirizzo' => $item["indirizzo"],
            'civico' => $item["civico"],
            'altro' => $item["altro"],

        ];
    }
}
