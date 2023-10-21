<?php

namespace App\Transformers;

use App\Models\Appointment;
use App\Utils\TransformersUtil;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

/**
 *
 */
class AppointmentTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected array $defaultIncludes = ['doctor', 'patient'];

    /**
     * @var array|string[]
     */
    protected array $availableIncludes = ['doctor', 'patient'];

    /**
     * @param Appointment $appointment
     * @return array
     */
    public function transform(Appointment $appointment): array
    {
        return [
            'id'                   => (string)$appointment->id,
            'doctor_id'            => (string)$appointment->doctor_id,
            'patient_id'           => (string)$appointment->patient_id,
            'date_time'            => $appointment->date_time,
            'time'                 => $appointment->date_time ? $appointment->date_time->format('H:i') : null,
            'date'                 => $appointment->date_time ? $appointment->date_time->format('Y-m-d') : null,
            'service_name'         => $appointment->service_name,
            'deleted_at'           => $appointment->deleted_at,
            'created_at'           => $appointment->created_at,
            'created_at_formatted' => TransformersUtil::dateTimeFormatted($appointment->created_at),
            'updated_at'           => $appointment->updated_at,
            'updated_at_formatted' => TransformersUtil::dateTimeFormatted($appointment->updated_at),
        ];
    }

    /**
     * @param Appointment $appointment
     * @return Item
     */
    public function includeDoctor(Appointment $appointment): Item
    {
        return $this->item($appointment->doctor, new UserTransformer);
    }

    /**
     * @param Appointment $appointment
     * @return Item
     */
    public function includePatient(Appointment $appointment): Item
    {
        return $this->item($appointment->patient, new UserTransformer);
    }
}
