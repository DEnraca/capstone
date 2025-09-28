<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
if (! function_exists('generateEmpId')) {
    function generateEmpId()
    {
        $year = Carbon::now()->format('Y');

        // Get the latest emp_id for the current year
        $latest = DB::table('employees')
            ->where('emp_id', 'like', "$year%")
            ->orderByDesc('emp_id')
            ->first();

        if (!$latest) {
            return sprintf("%s-%04d-%02d", $year, 0, 0);
        }

        // Parse the latest emp_id
        [$latestYear, $latestBackup, $latestCounter] = explode('-', $latest->emp_id);

        $backup = (int) $latestBackup;
        $counter = (int) $latestCounter;

        // Increment counter, and overflow to backup if needed
        if ($counter < 99) {
            $counter++;
        } else {
            $counter = 0;
            $backup++;
        }

        return sprintf("%s-%04d-%02d", $year, $backup, $counter);
    }
}

if (! function_exists('generateUniqueUserId')) {
    function generateUniqueUserId($length = 36)
    {
        do {
            // Generate random string
            $id = Str::random($length);

            // Check if it exists in users table
            $exists = DB::table('users')->where('id', $id)->exists();
        } while ($exists);

        return $id;
    }
}

if (! function_exists('generateUniqueUsername')) {

    function generateUniqueUsername($firstName, $middleName, $lastName)
    {
        // Normalize names (lowercase, no spaces)
        $firstName = strtolower(Str::slug($firstName, ''));
        $middleInitial = strtolower(substr($middleName ?? '', 0, 1));
        $lastName = strtolower(Str::slug($lastName, ''));

        do {
            $randomNumber = rand(10, 99); // 2-digit number
            $username = "{$firstName}.{$middleInitial}.{$lastName}{$randomNumber}";
        } while (User::where('username', $username)->exists());

        return $username;
    }
}

if (! function_exists('getAppointmentStatus')) {

    function getAppointmentStatus($id)
    {
        switch ($id) {
            case 1:
                return 'Pending';
            case 2:
                return 'Confirmed';
            case 3:
                return 'Cancelled';
            case 4:
                return 'Completed';
            default:
                return 'Unknown';
        }
    }
}

if (! function_exists('getRegionsCustom')) {

    function getRegionsCustom()
    {
        return DB::table('regions')->orderBy('name')->pluck('name', 'region_id')->toArray();
    }
}

if (! function_exists('getProvincesCustom')) {

    function getProvincesCustom($regionID)
    {
        return DB::table('provinces')->where('region_id',$regionID)->orderBy('name')->pluck('name', 'province_id')->toArray();
    }
}

if (! function_exists('getCitiesCustom')) {

    function getCitiesCustom($provinceID)
    {
        return DB::table('cities')->where('province_id',$provinceID)->orderBy('name')->pluck('name', 'city_id')->toArray();
    }
}


if (! function_exists('getBarangayCustom')) {

    function getBarangayCustom($cityID)
    {
        return DB::table('barangays')->where('city_id',$cityID)->orderBy('name')->pluck('name', 'id')->toArray();
    }
}








