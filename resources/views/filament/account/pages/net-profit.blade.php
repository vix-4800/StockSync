<x-filament-panels::page>
    <x-filament::input.wrapper>
        <x-filament::input.select wire:model="selectedAccount">
            @foreach ($accounts as $account)
                <option value="{{ $account->id }}">
                    {{ $account->name }} - {{ $account->marketplace }}
                </option>
            @endforeach
        </x-filament::input.select>
    </x-filament::input.wrapper>
</x-filament-panels::page>
