<?php

namespace App\Models\Views;

use App\Models\Appointment;

/**
 *
 */
class AppointmentPivotView extends Appointment
{
    /**
     * @var string
     */
    protected $table = 'appointment_pivot_view';
}
