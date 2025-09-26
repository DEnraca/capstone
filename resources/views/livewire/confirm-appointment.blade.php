
<div class="grid grid-cols-3 gap-2">
    <div class="col-span-1 grid gap-2">
        <x-filament::section class="shadow-md p-0">
            <x-slot name="heading">
                <div class="flex justify-between">
                    <span class="text-lg text-primary-500">
                        Booking Details
                    </span>
                    <span>
                        <a href="#" class="text-sm text-blue-600 hover:underline dark:text-blue-500">Edit</a>
                    </span>
                </div>
            </x-slot>
            <dl class="text-primary divide-y divide-gray-200">
                <div class="flex flex-col pb-1">
                    <dt class="mb-1 text-gray-500  dark:text-gray-400">Date & Time</dt>
                    <dd class="text-lg font-semibold">Sept 20, 2025 8:03 AM</dd>
                </div>
                <div class="flex flex-col pb-1">
                    <dt class="mb-1 text-gray-500  dark:text-gray-400">Message</dt>
                    <dd class="text-lg font-semibold">dennisenraca25@gmail.com</dd>
                </div>
            </dl>
        </x-filament::section>

        <x-filament::section class="shadow-md">
            <x-slot name="heading">
                <div class="flex justify-between">
                    <span class="text-lg text-primary-500">
                        Personal Information
                    </span>
                    <span>
                        <a href="#" class="text-sm text-blue-600 hover:underline dark:text-blue-500">Edit</a>
                    </span>
                </div>
            </x-slot>
            <dl class="text-primary divide-y divide-gray-200">
                <div class="flex flex-col pb-1">
                    <dt class="mb-1 text-gray-500  dark:text-gray-400">Full name</dt>
                    <dd class="text-lg font-semibold">Dennis Abellera Enraca</dd>
                </div>
                <div class="flex flex-col pb-1">
                    <dt class="mb-1 text-gray-500  dark:text-gray-400">Email</dt>
                    <dd class="text-lg font-semibold">dennisenraca25@gmail.com</dd>
                </div>
                <div class="flex flex-col pb-1">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Address</dt>
                    <dd class="text-lg font-semibold">1547 banlok st. Farmers Subd. Lolomboy Bocaue Bulacan</dd>
                </div>
                <div class="flex flex-col pb-1">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Mobile</dt>
                    <dd class="text-lg font-semibold">(+63) 9050449294</dd>
                </div>
                <div class="flex flex-col pb-1">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Date of birth</dt>
                    <dd class="text-lg font-semibold">June 25 1999</dd>
                </div>
                <div class="flex flex-col pb-1">
                    <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Civil Status - Gender</dt>
                    <dd class="text-lg font-semibold">Single - Male</dd>
                </div>
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
                        <a href="#" class="text-sm text-blue-600 hover:underline dark:text-blue-500">Edit</a>
                    </span>
                </div>
            </x-slot>
            <div class="grid grid-cols-3 gap-2 overflow-auto max-h-screen">
                @for($i = 0; $i < 3; $i++)
                    <x-filament::card class="col-span-1">
                        <div>
                            <img class="w-full h-32 mb-3 rounded-lg" src="https://flowbite.com/docs/images/blog/image-1.jpg" alt="Service Image">
                        </div>
                        <div class="flex flex-col">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="text-md font-semibold text-primary-600">Service Name</h3>
                                <span class="text-sm font-medium text-gray-500">$50.00</span>
                            </div>
                            <p class="text-sm text-gray-500">Service description goes here. It provides a brief overview of the service.</p>
                        </div>
                    </x-filament::card>
                @endfor
            </div>
            <div class="flex justify-end">
                <x-filament::button
                    type="button"
                    color="primary"
                >
                    Confirm Appointment
                </x-filament::button>
            </div>
        </x-filament::section>
    </div>

</div>


