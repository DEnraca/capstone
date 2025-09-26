<div>
    {{$this->form}}
    {{-- In work, do what you enjoy. --}}


    <div class="flex justify-end m-2">
        <x-filament::button wire:click="gotoNext" color="primary">
            Create Account
        </x-filament::button>
    </div>

    <div>
        <x-filament::modal
            id="appoinment-login-modal"
            width="md"
        >
            <x-slot name="heading">Account Sign In</x-slot>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Email
                </label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    required
                    autofocus
                    autocomplete="email"
                    tabindex="1"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                >
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Password
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    tabindex="2"
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
                >

                <!-- Forgot password link -->
                <div class="mt-2 text-sm">
                    <a href="/admin/password-reset/request" tabindex="3" class="text-primary-600 hover:underline">
                        Forgot your password?
                    </a>
                </div>
            </div>


            <x-slot name="footer">
                <x-filament::button wire:click="gotoNext" color="primary">
                    Sign In
                </x-filament::button>
                <x-filament::button x-on:click="$dispatch('close-modal', { id: 'appoinment-login-modal'})" color="gray">
                    Cancel
                </x-filament::button>
            </x-slot>
        </x-filament::modal>
    </div>



</div>



