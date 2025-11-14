<x-layouts.custom>

    <div class="w-full flex justify-between items-center py-3 px-6">
        <a href="{{ route('home') }}">
            <img src="{{ $logo ?? asset('images/logo.png') }}" alt="Logo" class=" w-[360px] object-contain">
        </a>
        <div class="flex">
            <a href="{{ route('home') }}" class="flex">
                <x-fas-chevron-left class="w-3 h-auto mr-2 text-slate-700 hover:text-amber-400" />
                Back to home
            </a>
            @if (auth()->check())
                <form method="POST" action="{{ route('filament.admin.auth.logout') }}">
                    @csrf
                    <button type="submit" class="ml-4 flex items-center text-red-600 hover:text-red-800">
                        <x-fas-power-off class="w-4 h-auto mr-1" />
                        Logout
                    </button>
                </form>
            @endif
        </div>

    </div>
    <div>
        @livewire('create-apointment')
    </div>
</x-layouts.custom>
