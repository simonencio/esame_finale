<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Store\ProfiloStoreRequest;
use App\Http\Requests\v1\Update\ProfiloUpdateRequest;
use App\Http\Resources\v1\Collection\ProfiloCollection;
use App\Http\Resources\v1\CollectionComplete\ProfiloCompletoCollection;
use App\Http\Resources\v1\Resource\ProfiloResource;
use App\Http\Resources\v1\ResourceComplete\ProfiloCompletoResource;
use App\Models\Profilo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProfiloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResource
     */

    public function index()
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente') || Gate::allows('Ospite')) {
                $profilo = Profilo::all();
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new ProfiloCompletoCollection($profilo);
                } else {
                    $risorsa = new ProfiloCollection($profilo);
                }
                return $risorsa;
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, 'PE_0002');
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Requests\v1\CategoriaStoreRequest $request
     * @return JsonResource
     */

    public function store(ProfiloStoreRequest $request)
    {
        if (Gate::allows('creare')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $dati = $request->validated();
                $profilo = Profilo::create($dati);
                return new ProfiloResource($profilo);
            } else {
                abort(403, "PE_0001");
            }
        } else {
            abort(403, "PE_0002");
        }
    }

    /**
     * Display the specified resource.
     * @param \App\Models\Categoria $profilo
     * @return JsonResource
     */

    public function show(Profilo $profilo)
    {
        if (Gate::allows('leggere')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $risorsa = null;
                if (request("tipo") != null && request("tipo") == "completo") {
                    $risorsa = new ProfiloCompletoResource($profilo);
                } else {
                    $risorsa = new ProfiloResource($profilo);
                }
                return $risorsa;
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, 'PE_0002');
        }
    }

    /**
     * Update the specified resource in storage.
     * @param \App\Models\TipologiaIndirizzo $tipologiaIndirizzo
     * @param \Illuminate\Http\Requests\v1|TipologiaIndirizzoUpdateRequest $request
     * * @return JsonResource
     */


    public function update(ProfiloUpdateRequest $request, Profilo $profilo)
    {

        if (Gate::allows('aggiornare')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $dati = $request->validated();
                $profilo->fill($dati);
                $profilo->save();
                return new ProfiloResource($profilo);
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, "PE_0002");
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param \App\Models\TipologiaIndirizzo $tipologiaIndirizzo
     */

    public function destroy(Profilo $profilo)
    {
        if (Gate::allows('eliminare')) {
            if (Gate::allows('Amministratore') || Gate::allows('Utente')) {
                $profilo->deleteOrFail();
                return response()->noContent();
            } else {
                abort(403, 'PE_0001');
            }
        } else {
            abort(403, 'PE_0002');
        }
    }
}
