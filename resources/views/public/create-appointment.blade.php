<x-layouts.custom>
        <div class="w-auto" style="height: 10%">
            <div class="flex justify-center items-center">
                <a href="{{route('home')}}">
                    <img src="{{ $logo ?? asset('images/logo.png') }}" alt="Logo" class="w-full max-h-full object-contain">
                </a>
            </div>
        </div>
        <div>
            @livewire('create-apointment')
        </div>
</x-layouts.custom>