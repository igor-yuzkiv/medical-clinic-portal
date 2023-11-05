<?php

namespace App\Containers\Appointment\Http\Requests;

use App\Containers\Appointment\DTO\AppointmentDto;
use App\Containers\Appointment\Enums\ServiceType;
use App\Containers\Patient\DTO\PatientDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 *
 */
class SaveAppointmentRequest extends FormRequest
{
    /**
     * @return array[]
     */
    public function rules(): array
    {
        $serviceTypes = array_map(fn($type) => $type->value, ServiceType::cases());
        return [
            'patient_id'     => ['nullable', 'integer'],
            'patient_name'   => ['nullable', 'string', 'required_without:patient_id'],
            'patient_phone'  => ['nullable', 'string', 'required_without:patient_id'],
            'service_type'   => ['required', Rule::in($serviceTypes)],
            'date_time'      => ['required', 'date'],
            'is_new_patient' => ['bool'],
        ];
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return AppointmentDto
     */
    public function getAppointmentDto(): AppointmentDto
    {
        $data = \Arr::except($this->validated(), ["patient_name", "patient_phone"]);
        $data['doctor_id'] = auth()->user()->id;

        if ($this->input("patient_name") && $this->input("patient_phone")) {
            $data["patient"] = PatientDto::of([
                "name"  => $this->input("patient_name"),
                "phone" => $this->input("patient_phone"),
            ]);
        }
        return AppointmentDto::of($data);
    }
}
