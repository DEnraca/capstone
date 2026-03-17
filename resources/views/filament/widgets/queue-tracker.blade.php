<x-filament::widget>
    <x-filament::card>

        <h2 class="text-lg font-bold mb-1 text-center text-primary-500 uppercase">
            Queue Tracker
        </h2>

        <div
            x-data="{
                isDown:false,
                startX:0,
                scrollLeft:0,

                init(){
                    this.$nextTick(() => {
                        let current = this.$el.querySelector('[data-current]');
                        if(current){
                            current.scrollIntoView({
                                behavior:'smooth',
                                inline:'center',
                                block:'nearest'
                            });
                        }
                    })
                }
            }"

            x-on:mousedown="
                isDown=true;
                startX=$event.pageX;
                scrollLeft=$el.scrollLeft;
            "

            x-on:mouseleave="isDown=false"
            x-on:mouseup="isDown=false"

            x-on:mousemove="
                if(!isDown) return;
                let walk = ($event.pageX - startX) * 1.5;
                $el.scrollLeft = scrollLeft - walk;
            "

            class="overflow-x-auto cursor-grab active:cursor-grabbing select-none"
        >

            <div class="flex items-center gap-8 min-w-max py-6 px-4">

                @foreach($this->getSteps() as $step)

                    <div
                        class="flex flex-col items-center relative min-w-[120px]"
                        @if($step->is_current)
                            data-current
                        @endif
                    >

                        {{-- connector --}}
                        @if(!$loop->first)
                            <div class="absolute -left-10 top-5 w-10 h-1
                                @if($step->latest_status == 4)
                                    bg-success-500
                                @else
                                    bg-gray-300
                                @endif
                            "></div>
                        @endif

                        {{-- circle --}}
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold

                            @if($step->latest_status == 4)
                                bg-success-500
                            @elseif($step->is_current)
                                bg-warning-500 animate-pulse
                            @else
                                bg-gray-300 text-gray-700
                            @endif
                        ">

                            @if($step->latest_status == 4)
                                ✓
                            @elseif($step->is_current)
                                ●
                            @else
                                {{ $loop->iteration }}
                            @endif

                        </div>

                        {{-- label --}}
                        <div class="mt-3 text-center">

                            <div class="font-bold text-md text-gray-500">
                                {{ $step->station?->name ?? 'Station'}}
                            </div>

                            <div class="text-xs font-semibold text-primary-500">
                                @if ($step->is_default_step)

                                    {{ \Illuminate\Support\Str::headline($step?->step_name ?? 'unknown_step')}}
                                @else
                                    <b>{{ $step->service?->name ?? 'Unknown Service'}}</b>


                                @endif
                                {{-- {{ $step->step?->name ?? $step}} --}}
                            </div>

                            <div class="text-xs text-gray-500">
                                {{ $step->status?->name }}
                            </div>

                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>