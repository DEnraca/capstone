
<div class="grid grid-cols-3 gap-2">
    @php
        $selectedService = session('selected_service',[]);
        $appointment_form = session('appointment_form',[]);
    @endphp
    <div class="col-span-1 grid gap-2">
        <x-filament::section class="shadow-md p-0">
            <x-slot name="heading">
                <div class="flex justify-between">
                    <span class="text-lg text-primary-500">
                        Booking Details
                    </span>
                    <span>
                        <button
                            wire:click="getPage(2)"
                            class="text-sm text-blue-600 hover:underline dark:text-blue-500">Edit
                        </button>
                    </span>
                </div>
            </x-slot>
            @if (!empty($appointment_form['book']))
                <dl class="text-primary divide-y divide-gray-200">
                    <div class="flex flex-col pb-1">
                        <dt class="mb-1 text-gray-500  dark:text-gray-400">Date & Time</dt>
                        <dd class="text-lg font-semibold">
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i', $appointment_form['book']['appointment_date'].' '. $appointment_form['book']['appointment_time'] ?? null)
                                    ->format('F d Y g:i A') }}
                        </dd>
                    </div>
                    <div class="flex flex-col pb-1">
                        <dt class="mb-1 text-gray-500  dark:text-gray-400">Message</dt>
                        <dd class="text-lg font-semibold">{{$appointment_form['book']['message'] ?? 'N/A'}}</dd>
                    </div>
                </dl>
            @else
                <div class="flex justify-items-center items-center text-center">
                    <span class="text-gray-400 text-center">No Book Details Found</span>
                </div>
            @endif


        </x-filament::section>

        <x-filament::section class="shadow-md">
            <x-slot name="heading">
                <div class="flex justify-between">
                    <span class="text-lg text-primary-500">
                        Personal Information
                    </span>
                    <span>
                        <button
                            wire:click="getPage(2)"
                            class="text-sm text-blue-600 hover:underline dark:text-blue-500">Edit
                        </button>
                    </span>
                </div>
            </x-slot>
            <dl class="text-primary divide-y divide-gray-200">

                 @if (!empty($appointment_form['info']) && !empty($appointment_form['account']))
                    <dl class="text-primary divide-y divide-gray-200">
                        <div class="flex flex-col pb-1">
                            <dt class="mb-1 text-gray-500  dark:text-gray-400">Full name</dt>
                            <dd class="text-lg font-semibold">{{$appointment_form['info']['first_name']}} {{$appointment_form['info']['middle_name']}} {{$appointment_form['info']['last_name']}}</dd>
                        </div>
                        <div class="flex flex-col pb-1">
                            <dt class="mb-1 text-gray-500  dark:text-gray-400">Email</dt>
                            <dd class="text-lg font-semibold">{{$appointment_form['account']['email']}}</dd>
                        </div>
                        <div class="flex flex-col pb-1">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Address</dt>
                            <dd class="text-lg font-semibold">
                                @if(!empty($appointment_form['address']))
                                    @php
                                        $add = $appointment_form['address'];
                                        $details = getAddressDetails($add['region_id'],$add['province_id'],$add['city_id'],$add['barangay_id']);
                                    @endphp
                                    {{ $add['house_address']}},
                                    {{ $details['barangay'] }}
                                    {{ $details['city'] }},
                                    {{ $details['province'] }},
                                    {{ $details['region'] }}
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>
                        <div class="flex flex-col pb-1">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Mobile</dt>
                            <dd class="text-lg font-semibold">(+63) {{$appointment_form['info']['mobile']}}</dd>
                        </div>
                        <div class="flex flex-col pb-1">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Date of birth</dt>
                            <dd class="text-lg font-semibold"> {{\Carbon\Carbon::parse($appointment_form['info']['dob'])->isoFormat('MMMM DD YYYY')}}</dd>
                        </div>
                        <div class="flex flex-col pb-1">
                            <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Civil Status - Gender</dt>
                            <dd class="text-lg font-semibold">
                                {{\App\Models\CivilStatus::find($appointment_form['info']['civil_status'])?->name ?? 'N/A'}}
                                    -
                                {{\App\Models\Gender::find($appointment_form['info']['gender'])?->name ?? 'N/A'}}
                            </dd>
                        </div>
                    </dl>
                @else
                    <div class="flex justify-items-center items-center text-center">
                        <span class="text-gray-400 text-center">No Patient Information Found</span>
                    </div>
                @endif
            </dl>
        </x-filament::section>
    </div>
    <div class="col-span-2">

        <x-filament::section class="shadow-md">
            <x-slot name="heading">
                <div class="flex justify-between">
                    <span class="text-lg text-primary-500">
                        Services Booked
                    </span>
                    <span>

                        <button
                            wire:click="getPage(1)"
                            class="text-sm text-blue-600 hover:underline dark:text-blue-500">Edit
                        </button>
                    </span>
                </div>
            </x-slot>
            @php
                $services = App\Models\Service::whereIn('id', $selectedService)->get();
            @endphp
            <div class="grid grid-cols-3 gap-2 overflow-auto max-h-screen">
                @foreach ($services as $service)
                    <x-filament::card class="col-span-1">
                        <div>
                            <img class="w-full h-32 mb-3 rounded-lg" src="https://flowbite.com/docs/images/blog/image-1.jpg" alt="Service Image">
                        </div>
                        <div class="flex flex-col">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="text-md font-semibold text-primary-600">{{$service->name}}</h3>
                                <span class="text-sm font-medium text-gray-500">₱ {{number_format($service->price,2)}}</span>
                            </div>
                            <p class="text-sm text-gray-500">{!! $service->description !!}</p>
                        </div>
                    </x-filament::card>
                @endforeach
            </div>
            <div class="flex justify-end gap-1">
                <x-filament::button x-on:click="$dispatch('backPage', { page: 2})" color="gray">
                    Back
                </x-filament::button>
                <x-filament::button
                    type="button"
                    color="primary"
                    wire:click="saveAppointment"
                >
                    Confirm Appointment
                </x-filament::button>
            </div>
        </x-filament::section>
    </div>

</div>


