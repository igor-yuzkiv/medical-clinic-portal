<?php

namespace App\Containers\Patient\Http\Controllers;

use App\Abstractions\Controller\ResourceController;
use App\Abstractions\Serializer\DataArraySerializer;
use App\Containers\Patient\Http\Requests\SavePatientRequest;
use App\Containers\Patient\Models\Patient;
use App\Containers\Patient\Transformers\PatientTransformer;
use App\Utils\LoggerUtil;
use App\Utils\ResponseUtil;
use Illuminate\Http\Request;
use League\Fractal\Serializer\ArraySerializer;

/**
 *
 */
class PatientController extends ResourceController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @param SavePatientRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SavePatientRequest $request)
    {
        try {
            $data = $request->validated();
            if (!isset($data['user_id'])) {
                $data['user_id'] = auth()->user()->id;
            }

            $patient = Patient::create($data);
            return fractal($patient)
                ->serializeWith(ArraySerializer::class)
                ->transformWith(new PatientTransformer())
                ->respond();
        } catch (\Exception $exception) {
            LoggerUtil::exception($exception);
            return ResponseUtil::exception($exception);
        }
    }

    /**
     * @param Patient $patient
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Patient $patient)
    {
        return fractal($patient)
            ->serializeWith(ArraySerializer::class)
            ->transformWith(new PatientTransformer())
            ->respond();
    }

    /**
     * @param Patient $patient
     * @param SavePatientRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Patient $patient, SavePatientRequest $request)
    {
        try {
            $data = $request->validated();
            if (!isset($data['user_id'])) {
                $data['user_id'] = auth()->user()->id;
            }

            $patient->update($data);
            return fractal($patient)
                ->serializeWith(ArraySerializer::class)
                ->transformWith(new PatientTransformer())
                ->respond();
        } catch (\Exception $exception) {
            LoggerUtil::exception($exception);
            return ResponseUtil::exception($exception);
        }
    }

    /**
     * @param Patient $patient
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Patient $patient)
    {
        try {
            $patient->delete();
            return response()->json(null, 204);
        } catch (\Exception $exception) {
            LoggerUtil::exception($exception);
            return ResponseUtil::exception($exception);
        }
    }
}
