<div>
    <x-jet-dialog-modal wire:model="showingEquipmentDetail">
        <x-slot name="title">
            <p>{{ $equipment->name }}</p>
        </x-slot>

        <x-slot name="content">
            <img class="border mx-auto max-w-xs" src="{{ $equipment->picture_url }}" alt="{{ $equipment->name }}">
            <table class="mt-3 w-full">
                <tr>
                    <th scope="col" class="border">{{ __('app.equipments.model') }}</th>
                    <td class="border">{{ $equipment->name }}</td>
                </tr>
                <tr>
                    <th scope="col" class="border">{{ __('app.equipments.brand') }}</th>
                    <td class="border">{{ $equipment->brand }}</td>
                </tr>
                <tr>
                    <th scope="col" class="border">{{ __('app.equipments.type') }}</th>
                    <td class="border">{{ $equipment->category }}</td>
                </tr>
                <tr>
                    <th scope="col" class="border">{{ __('app.equipments.serial') }}</th>
                    <td class="border">{{ $equipment->serial_number }}</td>
                </tr>
                <tr>
                    <th scope="col" class="border">{{ __('app.sub-department') }}</th>
                    <td class="border">{{ $equipment->subDepartment }}</td>
                </tr>
                <tr>
                    <th scope="col" class="border">{{ __('app.details') }}</th>
                    <td class="border">{{ $equipment->detail }}</td>
                </tr>
            </table>
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-ghost" wire:click="$toggle('showingEquipmentDetail')">
                {{ __('app.close') }}
            </button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
