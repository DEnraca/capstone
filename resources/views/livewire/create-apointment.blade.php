<div>

    <ol class="h-[10%] flex items-center w-full p-3 space-x-1 text-sm font-medium text-center text-primary-400  border border-gray-200 rounded-lg shadow-xs  sm:text-base sm:p-4 sm:space-x-4 rtl:space-x-reverse">
        <li class="flex items-center">
            <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-600 rounded-full shrink-0">
                @if (true) <x-fas-check-circle></x-fas-check-circle>
                @else 1 @endif
            </span>
            Select Service
            <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
            </svg>
        </li>
        <li class="flex items-center">
            <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-600 rounded-full shrink-0">
                @if (false) <x-fas-check-circle></x-fas-check-circle>
                @else 2 @endif
            </span>
            Appointment Details
            <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
            </svg>
        </li>

        <li class="flex items-center">
            <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-600 rounded-full shrink-0">
                @if (false) <x-fas-check-circle></x-fas-check-circle>
                @else 3 @endif
            </span>
            Account
            <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
            </svg>
        </li>
        <li class="flex items-center">
            <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-600 rounded-full shrink-0">
                @if (false) <x-fas-check-circle></x-fas-check-circle>
                @else 4 @endif
            </span>
            Confirm
        </li>
    </ol>

    <div class="">
        @livewire('select-service')
    </div>


    {{-- <form wire:submit="create">
        {{ $this->form }}

    </form> --}}

</div>
