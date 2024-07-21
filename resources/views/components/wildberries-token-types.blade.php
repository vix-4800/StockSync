<x-filament::modal slide-over>
    <x-slot name="trigger">
        <x-filament::badge tooltip="{{ __('Hints for API Token Types') }}">
            {{ __('API Token Types') }}
        </x-filament::badge>
    </x-slot>

    <x-slot name="heading">
        {{ __('Needed API Token Permissions') }}
    </x-slot>

    <livewire:wildberries-token-types />
</x-filament::modal>
