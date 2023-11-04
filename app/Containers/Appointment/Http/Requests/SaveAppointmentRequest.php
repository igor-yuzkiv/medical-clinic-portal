<?php

namespace App\Containers\Appointment\Http\Requests;

use App\Containers\Appointment\DTO\AppointmentDto;
use App\Containers\Patient\DTO\PatientDto;
use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'patient_id'    => ['nullable', 'integer'],
            'patient_name'  => ['nullable', 'string', 'required_without:patient_id'],
            'patient_phone' => ['nullable', 'string', 'required_without:patient_id'],
            'date_time'     => ['required', 'date'],
            'service_name'  => ['required'],
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
