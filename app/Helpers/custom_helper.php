<?php

use App\Models\Employee;
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


if (! function_exists('getAddressDetails')) {

    function getAddressDetails($regionID, $provinceID, $cityID, $barangayID)
    {
        $region = getRegionsCustom()[$regionID] ?? null;
        $province = getProvincesCustom($regionID)[$provinceID] ?? null;
        $city = getCitiesCustom($provinceID)[$cityID] ?? null;
        $barangay = getBarangayCustom($cityID)[$barangayID] ?? null;

        return [
            'region' => $region,
            'province' => $province,
            'city' => $city,
            'barangay' => $barangay,
        ];
    }
}

if (! function_exists('generatePatID')) {
    function generatePatID()
    {
        $year = Carbon::now()->format('Y');

        // Get the latest emp_id for the current year
        $latest = DB::table('patient_information')
            ->where('pat_id', 'like', "$year%")
            ->orderByDesc('pat_id')
            ->first();

        if (!$latest) {
            return sprintf("%s-%04d-%02d", $year, 0, 0);
        }

        // Parse the latest emp_id
        [$latestYear, $latestBackup, $latestCounter] = explode('-', $latest->pat_id);

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

if (! function_exists('generateQueueNumber')) {
    /**
     * Generate a unique queue number with type prefix and sequence per day.
     *
     * Example output: A-0001
     */
    function generateQueueNumber(int $type = 1): string
    {
        $prefix = match ($type) {
            2 => 'W',
            3 => 'P',
            1 => 'A',
            default => 'U',
        };

        return DB::transaction(function () use ($prefix) {

            $today = Carbon::today();

            // Get latest queue number for today & same type
            $latest = DB::table('queues')
                ->whereDate('created_at', $today)
                ->where('queue_number', 'like', "{$prefix}-%")
                ->lockForUpdate()
                ->orderByDesc('queue_number')
                ->first();

            $nextSequence = 1;

            if ($latest && preg_match('/(\d{4})$/', $latest->queue_number, $matches)) {
                $nextSequence = (int) $matches[1] + 1;
            }

            // Limit to 9999 per day
            if ($nextSequence > 9999) {
                throw new Exception("Queue limit reached for today.");
            }

            $formattedSeq = str_pad($nextSequence, 4, '0', STR_PAD_LEFT);
            $queueNo = "{$prefix}-{$formattedSeq}";

            return $queueNo;
        });

    }


    if (! function_exists('generateTransCode')) {
        function generateTransCode()
        {
            $year = Carbon::now()->format('Y');

            // Get the latest emp_id for the current year
            $latest = DB::table('transactions')
                ->where('code', 'like', "$year%")
                ->orderByDesc('code')
                ->first();

            if (!$latest) {
                return sprintf("%s-%04d-%02d", $year, 0, 0);
            }

            // Parse the latest emp_id
            [$latestYear, $latestBackup, $latestCounter] = explode('-', $latest->code);

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


    if (! function_exists('generateInvoiceCode')) {
        function generateInvoiceCode()
        {
            $year = Carbon::now()->format('Y');

            // Get the latest emp_id for the current year
            $latest = DB::table('invoices')
                ->where('invoice_number', 'like', "$year%")
                ->orderByDesc('invoice_number')
                ->first();

            if (!$latest) {
                return sprintf("%s-%04d-%02d", $year, 0, 0);
            }

            // Parse the latest emp_id
            [$latestYear, $latestBackup, $latestCounter] = explode('-', $latest->invoice_number);

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


    if (! function_exists('string_to_number')) {
        function string_to_number($string)
        {
            if ($string === null) {
                return 0;
            }

            // Remove everything except digits and decimal point
            $clean = preg_replace('/[^0-9.]/', '', $string);

            return (float) $clean;
        }
    }


    if (! function_exists('format_appoiment_details_for_queue')) {
        function format_appoiment_details_for_queue($record)
        {

            $patientName = $record->patient ?  $record->patient->first_name. ' '. $record->patient->last_name:  'Unknown';
            $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $record->appointment_date.' '. $record->appointment_time ?? null)
                ->format('F d Y g:i A');

            $date = $date ?? 'No Date';
            $services = $record->services->pluck('name')->join(', ');

            // Build a label like: "John Doe - June 24, 2007 (Services: Service 1, Service 2)"

            return "{$patientName} - {$date} • Services: {$services}";
        }
    }


    if (! function_exists('verify_employee_handler')) {
        function verify_employee_handler()
        {
            return auth()->user()->employee?->id ?? Employee::where('position_id',2)->first()?->id ?? null;
        }
    }


}