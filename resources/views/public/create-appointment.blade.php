<x-layouts.custom>

    <div class="w-full flex justify-between items-center py-3 px-6">
        <a href="{{ route('home') }}">
            <img src="{{ $logo ?? asset('images/logo.png') }}" alt="Logo" class=" w-[360px] object-contain">
        </a>
        <a href="{{ route('home') }}">
            <x-fas-chevron-left class="w-3 h-auto text-slate-700 hover:text-amber-400" />
        </a>

    </div>
    <div>
        @livewire('create-apointment')
    </div>
</x-layouts.custom>
