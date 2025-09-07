<div>

    <div class="grid grid-cols-[1fr_25%] gap-2">
        <div>
            @livewire('services-table')
        </div>
        <div class="min-h-full">
            <ul class="max-w-md divide-y divide-gray-200 grid grid-rows-[8%_1fr] gap-2 h-full">
                <div class="flex items-center justify-center">
                    <h4 class="text-bold text-lg text-center ">Selected Service: {{count($this->selectedService)}}</h4>
                </div>
                <div>
                    <li class="pb-3 sm:pb-4">
                        @if (!empty($this->selectedService))
                            @foreach ($this->selectedService as $service)
                                @php
                                    $service = (object) $service;
                                @endphp
                                <div class="flex items-center space-x-4 py-2 rtl:space-x-reverse cursor-pointer" wire:click="handleServiceRemove({{$service->id}})">
                                    <div class="shrink-0 p-1 m-0 flex justify-center">
                                        <img class="w-18 h-14 rounded-lg" src="{{asset('images/frontend_asset/cardiac.jpg')}}" alt="Neil image">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-black truncate">
                                            {{$service->code}}
                                        </p>
                                        <p class="text-sm text-primary-500 truncate">
                                            {{$service->name}}
                                        </p>
                                    </div>
                                    <div class="inline-flex items-center text-base font-semibold text-gray-900 justify-center">
                                        <x-fas-trash class="w-8 h-4 text-danger-500"></x-fas-trash>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </li>
                </div>
            </ul>
        </div>
    </div>
</div>
