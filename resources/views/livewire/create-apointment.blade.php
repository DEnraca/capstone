<div>
    <div
        class="flex items-center justify-around  border border-gray-200 rounded-lg shadow-xs items-center gap-3 min-w-full py-1">
        <ol
            class="h-[10%] flex items-center justify-center w-full p-3 space-x-1 text-xs font-bold text-center text-primary-400 rtl:space-x-reverse">
            <li class=" flex items-center cursor-pointer">
                <span
                    class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-600 rounded-full shrink-0">
                    @if ($page['page1'])
                        <x-fas-check-circle></x-fas-check-circle>
                    @else
                        1
                    @endif
                </span>
                Select Service
                <svg class="w-3 h-3 ms-3 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>
            <li class="flex items-center">
                <span
                    class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-600 rounded-full shrink-0">
                    @if ($page['page2'])
                        <x-fas-check-circle></x-fas-check-circle>
                    @else
                        2
                    @endif
                </span>
                Appointment Details
                <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 12 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m7 9 4-4-4-4M1 9l4-4-4-4" />
                </svg>
            </li>

            <li class="flex items-center">
                <span
                    class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-600 rounded-full shrink-0">
                    @if ($page['page3'])
                        <x-fas-check-circle></x-fas-check-circle>
                    @else
                        3
                    @endif
                </span>
                Confirm
            </li>
        </ol>
    </div>
    <div class="p-2">
        @if ($page['current_page'] == 1)
            @livewire('select-service')
        @endif
        @if ($page['current_page'] == 2)
            @livewire('appointment-account')
        @endif
        @if ($page['current_page'] == 3)
            @include('livewire.confirm-appointment')
        @endif
    </div>
</div>
