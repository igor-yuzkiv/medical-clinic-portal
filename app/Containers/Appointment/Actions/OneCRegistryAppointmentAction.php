<?php

namespace App\Containers\Appointment\Actions;

use App\Abstractions\Action\ActionInterface;
use App\Abstractions\Job\Job;
use App\Containers\Appointment\Models\Appointment;
use App\Utils\LoggerUtil;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

/**
 *
 */
class OneCRegistryAppointmentAction extends Job implements ActionInterface
{
    /**
     * @param Appointment $appointment
     */
    public function __construct(private readonly Appointment $appointment)
    {

    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(): void
    {
        $client = new Client(['verify' => false, 'http_errors' => false]);
        $response = $client->post(
            config("project.one_c.appointment_registry_endpoint"),
            [RequestOptions::JSON => $this->getRequestData()]
        );

        LoggerUtil::info("[OCE_C] [AppointmentRegistry]", [
            "id"     => $this->appointment->id,
            "status" => $response->getStatusCode(),
            "body"   => $response->getBody()->getContents()
        ]);
    }


    /**
     * @return array
     */
    private function getRequestData(): array
    {
        $patient = $this->appointment->patient;
        $doctor = $this->appointment->doctor;

        //TODO: remove this test id
        $testDoctorId = "fbf57129-3b5b-11ee-811d-3cecef8fe309";

        return [
            "ZapysID"          => (string)$this->appointment->id,
            "DoctorID"         => (string)$doctor->source_id,
            //"DoctorID"         => $testDoctorId,
            "DoctorName"       => $doctor->name,
            "PacientName"      => $patient->name,
            "PacientTelephone" => (string)$patient->phone,
            "Type"             => (string)$this->appointment->service_type->value,
            "Data"             => $this->appointment->date_time->format("Y-m-d")
        ];
    }
}
