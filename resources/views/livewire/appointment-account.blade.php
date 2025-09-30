<div>
    {{$this->form}}
    {{-- In work, do what you enjoy. --}}


    <div class="flex justify-end m-2 gap-1">
        <x-filament::button x-on:click="$dispatch('backPage', { page: 1})" color="gray">
            Back
        </x-filament::button>

        <x-filament::button wire:click="submit" color="primary">
            Proceed booking confirmation
        </x-filament::button>
    </div>

    <div>
        <x-filament::modal
            id="appoinment-login-modal"
            width="md"
        >
            <x-slot name="heading">Account Sign In</x-slot>

                <div class="space-y-4">
                    <x-filament::input.wrapper>
                        <x-filament::input type="email" wire:model.defer="email" placeholder="Email"/>
                    </x-filament::input.wrapper>
                    @error('email')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror

                    <x-filament::input.wrapper>
                        <x-filament::input type="password" wire:model.defer="password" placeholder="Password" />
                    </x-filament::input.wrapper>
                    @error('password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <x-slot name="footer">
                    <x-filament::button wire:click="login" color="primary">
                        Sign In
                    </x-filament::button>
                    <x-filament::button x-on:click="$dispatch('close-modal', { id: 'appoinment-login-modal'})" color="gray">
                        Cancel
                    </x-filament::button>
                </x-slot>
        </x-filament::modal>
    </div>



</div>



