<div>
    <x-jet-dialog-modal wire:model="showing">
        <x-slot name="title">
            <p>{{ $this->equipment['name'] ?? ''}}</p>
        </x-slot>

        <x-slot name="content">
            <img class="border mx-auto max-w-xs" src="{{ $this->equipment['picture_url'] ?? ''}}" alt="{{ $this->equipment['name'] ?? ''}}">
            <table class="mt-3 w-full">
                <tr>
                    <th scope="col" class="border">{{ __('app.equipments.model') }}</th>
                    <td class="border">{{ $this->equipment['name'] ?? ''}}</td>
                </tr>
                <tr>
                    <th scope="col" class="border">{{ __('app.equipments.brand') }}</th>
                    <td class="border">{{ $this->equipment['brand'] ?? ''}}</td>
                </tr>
                <tr>
                    <th scope="col" class="border">{{ __('app.equipments.type') }}</th>
                    <td class="border">{{ $this->equipment['category'] ?? ''}}</td>
                </tr>
                <tr>
                    <th scope="col" class="border">{{ __('app.equipments.serial') }}</th>
                    <td class="border">{{ $this->equipment['serial_number'] ?? ''}}</td>
                </tr>
                <tr>
                    <th scope="col" class="border">{{ __('app.sub-department') }}</th>
                    <td class="border">{{ $this->equipment['sub_department'] ?? ''}}</td>
                </tr>
                <tr>
                    <th scope="col" class="border">{{ __('app.details') }}</th>
                    <td class="border">{{ $this->equipment['detail'] ?? ''}}</td>
                </tr>
            </table>
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-ghost" wire:click="$toggle('showing')">
                {{ __('app.close') }}
            </button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
