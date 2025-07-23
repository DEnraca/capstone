<?php

use Carbon\Carbon;


if (! function_exists('get_appointment_timeslots')) {
    function get_appointment_timeslots()
    {
        $timeSlots = [];
        $start = Carbon::createFromTime(6, 0); // 6:00 AM
        $end = Carbon::createFromTime(20, 0);  // 8:00 PM

        while ($start <= $end) {
            $key = $start->format('H:i');        // e.g., "06:00"
            $value = $start->format('g:i A');    // e.g., "6:00 AM"
            $timeSlots[$key] = $value;
            $start->addMinutes(30);
        }

        return $timeSlots;
    }
}