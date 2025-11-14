<x-filament-widgets::widget>
    <div class="grid grid-cols-2 gap-2 place-content-center">
        <div style="border-color: #05df72; background-color: #dcfce7" class="border-2 rounded-lg shadow overflow-hidden text-black grid content-between p-4">
            <div>

                @if($current)
                    <p class="text-center text-xl px-4 py-2 uppercase">
                        now calling...
                    </p>
                    <p class="text-center text-4xl font-extrabold px-4 py-2 uppercase">
                        {{$current?->queue?->queue_number ?? 'N/A'}}
                    </p>
                    <p class="text-center font-bold px-4 py-2 uppercase">
                        {{$current?->queue->patient?->first_name ?? 'N/A'}}
                    </p>
                    <p class="text-center font-bold px-4 py-2">
                        {{$current?->station?->name ?? 'N/A'}}
                    </p>
                @else
                    <p class="text-center text-4xl font-bold px-4 py-2">
                        No Active Queue
                    </p>
                @endif
            </div>

            <div class="flex text-sm flex gap-3 justify-center items-center
                <?php if(!$current){ echo('opacity-75'); } ?>
                ">
                    @if($current?->latest_status == 1)
                        <x-filament::button class="px-4 py-2" color="success" :disabled="!$current" wire:click="setStatus(2)">
                            Process
                        </x-filament::button>
                    @endif
                    @if($current?->latest_status == 2)
                        <x-filament::button class="px-4 py-2" color="success" :disabled="!$current"
                            wire:click="complete()">
                            {{-- x-on:click="$"> --}}
                            Complete
                        </x-filament::button>
                    @endif
                    @if($current?->latest_status == 1)
                        <x-filament::button class="px-4 py-2" color="warning" :disabled="!$current" wire:click="recall({{$current->id}})">
                            Call Again
                        </x-filament::button>
                    @endif
                    @if($current?->latest_status == 1 || $current?->latest_status == 2)
                        <x-filament::button class="px-4 py-2" color="danger" :disabled="!$current" wire:click="setStatus(3)">
                            Pause
                        </x-filament::button>
                    @endif
            </div>
        </div>

        <div style="border-color: #efb100; background-color: #fef3c6" class="border-2 rounded-lg shadow overflow-hidden text-black grid content-between p-4">
            <div>

                @if($nextInLine)
                    <p class="text-center text-xl px-4 py-2 uppercase">
                        Next in Line
                    </p>
                    <p class="text-center text-4xl font-extrabold px-4 py-2 uppercase">
                        {{$nextInLine?->queue?->queue_number ?? 'N/A'}}
                    </p>
                    <p class="text-center font-bold px-4 py-2 uppercase">
                        {{$nextInLine?->queue?->patient?->first_name ?? 'N/A'}}
                    </p>
                    <p class="text-center font-bold px-4 py-2">
                        {{$nextInLine?->station?->name ?? 'N/A'}}
                    </p>
                @else
                    <p class="text-center text-4xl font-bold px-4 py-2">
                        No Next in Line
                    </p>
                @endif
            </div>

            <div class="flex text-sm flex justify-center items-center text-sm <?php if(!$nextInLine){ echo('opacity-75'); } ?>">
                @if ($nextInLine)
                    <x-filament::button class="px-4 py-2" color="warning" :disabled="!$nextInLine"  wire:click="setActive({{$nextInLine->id}})">
                        Call Next
                    </x-filament::button>
                @endif
            </div>
        </div>
    </div>

    <x-filament::modal
        id="patient-verify-modal"
        width="md"
    >

        <x-slot name="heading">Verify patient to complete</x-slot>
        @if(!$patient)
            @if($current)
                <div>
                    <p class="text-primary-500">You need to add patient information before completing this queue.  <a href="{{route('filament.admin.resources.patient-informations.create',['checklistID' => $current->id])}}" target="_blank" style="color:blue; !important">[Click here to add it.]</a> </p>
                </div>
            @endif
        @else
            <div class="space-y-4">
                <label for="patient" class="block text-sm font-medium text-gray-700">Select Patient</label>
                <x-filament::input.wrapper>
                    <x-filament::input.select wire:model="patient"
                        :disabled="!$patient"
                        >
                        <option value="" disabled>Select Patient</option>
                        @if (!empty($patients))
                            @foreach ($patients as $patient)
                                <option value="{{$patient->id}}">{{$patient->getFullname()}}</option>
                            @endforeach
                        @endif
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>
        @endif

        <x-slot name="footer">
            <x-filament::button wire:click="verifypatient" color="primary" :disabled="!$patient">
                Verify
            </x-filament::button>
        </x-slot>
    </x-filament::modal>
</x-filament-widgets::widget>
