<?php

namespace App\Containers\Patient\Http\Controllers;

use App\Abstractions\Serializer\DataArraySerializer;
use App\Containers\Patient\Models\Patient;
use App\Containers\Patient\Transformers\PatientTransformer;
use Illuminate\Http\Request;

class PatientController
{
    public function index(Request $request)
    {
        $appointments = Patient::query()
            ->orderBy("created_at", "desc");

        if ($request->input("filters")) {
            $appointments->filter($request->input("filters"));
        }

        if ($request->boolean('paginate', true)) {
            $appointments = $appointments->paginate($request->input('per_page', 10));
        } else {
            $appointments = $appointments->get();
        }

        $includes = explode(",", $request->get('includes', ""));

        return fractal($appointments)
            ->serializeWith(DataArraySerializer::class)
            ->parseIncludes($includes)
            ->withResourceName("data")
            ->transformWith(new PatientTransformer())
            ->respond();
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
