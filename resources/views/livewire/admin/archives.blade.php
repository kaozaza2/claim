<div>
    <div class="py-6">
        @livewire('admin-tab')

        <x-layout-box>
            <h1 class="text-xl mb-2">อุปกรณ์ตัดจำหน่าย</h1>

            <div class="overflow-x-auto">
                <table class="table table-compact border w-full table-zebra">
                    <thead>
                    <tr>
                        <th>
                            <span class="hidden lg:block">{{__('app.number')}}</span>
                        </th>
                        <th>{{__('app.equipments.model')}}</th>
                        <th>{{__('app.equipments.brand')}}</th>
                        <th>{{__('app.equipments.type')}}</th>
                        <th>{{__('app.equipments.serial')}}</th>
                        <th>{{__('app.details')}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($equipments as $key => $equipment)
                        <tr>
                            <th>{{ $equipment->id }}</th>
                            </td>
                            <td class="w-full">
                                {{ $equipment }}
                                <div wire:click="$emit('show-equipment-detail', {{ $equipment->id }})"
                                     class="inline-block cursor-pointer rounded-sm btn-ghost">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 0 24 24"
                                         width="14px" fill="#3d4451">
                                        <path d="M0 0h24v24H0V0z" fill="none"/>
                                        <path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/>
                                    </svg>
                                </div>
                            </td>
                            <td class="w-full">{{ $equipment->brand }}</td>
                            <td class="w-full">{{ $equipment->category }}</td>
                            <td class="font-mono">{{ $equipment->serial_number ?: '-' }}</td>
                            <td>{{ $equipment->detail }}</td>
                            <td>
                                <button class="btn btn-sm btn-success" wire:click="$emitSelf('recover', {{ $key }})">
                                    {{ __('app.recover') }}
                                </button>

                                <button class="btn btn-sm btn-error" wire:click="$emitSelf('delete', {{ $key }})">
                                    {{ __('app.full-delete') }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="">{{ __('app.empty') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </x-layout-box>
    </div>
</div>
