<?php

namespace App\Transformers;

use App\Models\Appointment;
use App\Models\Views\AppointmentPivotView;
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
    protected array $defaultIncludes = [];

    /**
     * @var array|string[]
     */
    protected array $availableIncludes = ['doctor', 'patient'];

    /**
     * @param Appointment|AppointmentPivotView $appointment
     * @return array
     */
    public function transform(Appointment|AppointmentPivotView $appointment): array
    {
        $result = [
            'id'                   => (string)$appointment->id,
            'doctor_id'            => (string)$appointment->doctor_id,
            'patient_id'           => (string)$appointment->patient_id,
            'date_time'            => $appointment->date_time ? $appointment->date_time->format('Y-m-d H:i') : null,
            'time'                 => $appointment->date_time ? $appointment->date_time->format('H:i') : null,
            'date'                 => $appointment->date_time ? $appointment->date_time->format('Y-m-d') : null,
            'service_name'         => $appointment->service_name,
            'deleted_at'           => $appointment->deleted_at,
            'created_at'           => $appointment->created_at,
            'created_at_formatted' => TransformersUtil::dateTimeFormatted($appointment->created_at),
            'updated_at'           => $appointment->updated_at,
            'updated_at_formatted' => TransformersUtil::dateTimeFormatted($appointment->updated_at),
        ];

        if ($appointment instanceof AppointmentPivotView) {
            $result['doctor_name'] = $appointment->doctor_name;
            $result['patient_name'] = $appointment->patient_name;
            $result['patient_name_initials'] = TransformersUtil::getInitials($appointment->patient_name);
            $result['patient_phone'] = $appointment->patient_phone;
        }

        return $result;
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
