<x-filament::widget class="filament-account-widget">
    <x-filament::card>

        @php
            $user = \Filament\Facades\Filament::auth()->user();
        @endphp

        <div class="h-12 flex items-center space-x-4 rtl:space-x-reverse">
            {{-- <x-filament::user-avatar :user="$user" /> --}}
            <div class="w-10 h-10 rounded-full bg-gray-200 bg-cover bg-center"
                 style="background-image: url('{{ \Filament\Facades\Filament::getUserAvatarUrl($user) }}')">
            </div>

            <div>
                <h2 class="text-lg sm:text-xl font-bold tracking-tight">
                    Welcome,
                    {{$user->name}}

                    <span class="inline-flex items-center rounded-md bg-gray-400/10 px-2 py-1 text-xs font-medium text-gray-400 inset-ring inset-ring-gray-400/20">{{ucwords(str_replace('_', ' ', $user->roles->pluck('name')->join(', '))) }}</span>
                </h2>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
