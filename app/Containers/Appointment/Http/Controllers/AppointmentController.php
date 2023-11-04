<?php

namespace App\Containers\Appointment\Http\Controllers;

use App\Abstractions\Controller\ResourceController;
use App\Abstractions\Serializer\DataArraySerializer;
use App\Containers\Appointment\Actions\CreateAppointmentProcedure;
use App\Containers\Appointment\Http\Requests\SaveAppointmentRequest;
use App\Containers\Appointment\Models\Appointment;
use App\Containers\Appointment\Models\Views\AppointmentPivotView;
use App\Containers\Appointment\Transformers\AppointmentTransformer;
use App\Utils\LoggerUtil;
use App\Utils\ResponseUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\Fractal\Serializer\ArraySerializer;

/**
 *
 */
class AppointmentController extends ResourceController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $appointments = AppointmentPivotView::query()
            ->orderBy(
                $request->input('orderBy', 'date_time'),
                $request->input('order', 'desc')
            );

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
            ->transformWith(new AppointmentTransformer())
            ->respond();
    }

    /**
     * @param SaveAppointmentRequest $request
     * @return JsonResponse
     */
    public function store(SaveAppointmentRequest $request): JsonResponse
    {
        try {
            $appointment = (new CreateAppointmentProcedure($request->getAppointmentDto()))->handle();
            return fractal($appointment)
                ->serializeWith(ArraySerializer::class)
                ->transformWith(new AppointmentTransformer())
                ->respond();
        } catch (\Exception $exception) {
            LoggerUtil::exception($exception);
            return ResponseUtil::exception($exception);
        }
    }

    /**
     * @param Appointment $appointment
     * @return JsonResponse
     */
    public function show(Appointment $appointment): JsonResponse
    {
        return fractal($appointment)
            ->serializeWith(ArraySerializer::class)
            ->transformWith(new AppointmentTransformer())
            ->respond();
    }

    /**
     * @param Appointment $appointment
     * @param SaveAppointmentRequest $request
     * @return JsonResponse
     */
    public function update(Appointment $appointment, SaveAppointmentRequest $request): JsonResponse
    {
        try {
            $dto = $request->getAppointmentDto();
            $appointment->update($dto->toArray());

            return fractal($appointment)
                ->serializeWith(ArraySerializer::class)
                ->transformWith(new AppointmentTransformer())
                ->respond();
        } catch (\Exception $exception) {
            LoggerUtil::exception($exception);
            return ResponseUtil::exception($exception);
        }
    }

    /**
     * @param Appointment $appointment
     * @return JsonResponse
     */
    public function destroy(Appointment $appointment): JsonResponse
    {
        try {
            $appointment->delete();
            return response()->json(null, 204);
        } catch (\Exception $exception) {
            LoggerUtil::exception($exception);
            return ResponseUtil::exception($exception);
        }
    }
}
