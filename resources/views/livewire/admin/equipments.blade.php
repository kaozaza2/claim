<div>
    <div class="py-12">
        <div class="tabs max-w-7xl mx-auto lg:px-8">
            <a href="{{ route('admin.claims') }}" class="tab tab-lifted">
                {{ __('รายการเคลมอุปกรณ์') }}
            </a>
            <a href="{{ route('admin.equipments') }}" class="tab tab-lifted tab-active">
                {{ __('รายการอุปกรณ์') }}
            </a>
            <a href="{{ route('admin.departments') }}" class="tab tab-lifted">
                {{ __('หน่วยงานและแผนก') }}
            </a>
            <a wire:click="$emit('showAccounts')" class="tab tab-lifted">
                {{ __('จัดการบัญชีผู้ใช้และแอดมิน') }}
            </a>
        </div>

        <div class="max-w-7xl sm:rounded-lg bg-white mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:py-6 lg:py-8 px-0">
                <div class="flex-none lg:flex mb-3">
                    <div class="form-control w-full mr-2">
                        <input type="text" wire:model="search" placeholder="ค้นหา" class="input input-bordered">
                    </div>
                    <button wire:click="showCreate" class="btn btn-success ml-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="transform rotate-45 inline-block w-6 h-6 mr-2 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        {{ __('เพิ่ม') }}
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-compact border w-full table-zebra">
                        <thead>
                        <tr>
                            <th>
                                <span class="hidden lg:block">{{__('รหัสอุปกรณ์')}}</span>
                            </th>
                            <th>{{__('รูป')}}</th>
                            <th>{{__('ชื่ออุปกรณ์')}}</th>
                            <th>{{__('เลขครุภัณฑ์')}}</th>
                            <th>{{__('รายละเอียด')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($equipments as $equipment)
                            <tr>
                                <th>{{ $equipment->id }}</th>
                                <td>
                                    <button wire:click="showPicture('{{ $equipment->id }}')" class="btn px-1 btn-sm btn-ghost">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000">
                                            <path d="M0 0h24v24H0V0z" fill="none"/>
                                            <path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/>
                                        </svg>
                                    </button>
                                </td>
                                <td class="w-full">{{ $equipment->name }}</td>
                                <td class="font-mono">{{ $equipment->serial_number ?: '-' }}</td>
                                <td>{{ $equipment->detail }}</td>
                                <td>
                                    <button class="btn btn-sm" wire:click="showUpdate('{{ $equipment->id }}')">
                                        {{ __('แก้ไข') }}
                                    </button>
                                    <button wire:click="confirmDeletion('{{ $equipment->id }}')" class="btn btn-sm btn-error">
                                        {{ __('ลบ') }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Show Picture -->
        <x-jet-dialog-modal wire:model="showingEquipmentPicture">
            <x-slot name="title">
                {{ optional($selected)->name }}
                <span class="badge badge-success">{{ optional($selected)->id }}</span>
            </x-slot>

            <x-slot name="content">
                <img class="border mx-auto max-w-xs" src="{{ optional($selected)->picture_url }}" alt="{{ optional($selected)->name }}">
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-ghost" wire:click="$toggle('showingEquipmentPicture')" wire:loading.attr="disabled">
                    {{ __('ปิด') }}
                </button>
            </x-slot>
        </x-jet-dialog-modal>

        <!-- Show Create -->
        <x-jet-modal wire:model="showingEquipmentCreate">
            <form wire:submit.prevent="storeEquipment">
                <div class="p-5">
                    @csrf
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('ชื่ออุปกรณ์') }}</span>
                        </label>
                        <input type="text" wire:model="name" placeholder="{{ __('ชื่ออุปกรณ์') }}"
                               class="input input-bordered">
                        @error('name')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('เลขครุภัณฑ์') }}</span>
                        </label>
                        <input type="text" wire:model="serial_number" placeholder="{{ __('เลขครุภัณฑ์') }}"
                               class="input input-bordered">
                        @error('serial_number')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('รายละเอียด') }}</span>
                        </label>
                        <textarea wire:model="detail" class="textarea h-24 textarea-bordered" placeholder="{{ __('รายละเอียด') }}"></textarea>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-100 text-right">
                    <button type="button" wire:click="$toggle('showingEquipmentCreate')" class="btn btn-ghost ml-auto">
                        {{ __('ยกเลิก') }}
                    </button>
                    <button type="submit" class="btn btn-success ml-2">{{ __('บันทึก') }}</button>
                </div>
            </form>
        </x-jet-modal>

        <!-- Show Update -->
        <x-jet-modal wire:model="showingEquipmentUpdate">
            <form wire:submit.prevent="updateEquipment">
                @csrf
                <div class="p-5">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('ชื่ออุปกรณ์') }}</span>
                        </label>
                        <input type="text" wire:model="name" placeholder="{{ __('ชื่ออุปกรณ์') }}"
                               class="input input-bordered">
                        @error('name')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('เลขครุภัณฑ์') }}</span>
                        </label>
                        <input type="text" wire:model="serial_number" placeholder="{{ __('เลขครุภัณฑ์') }}"
                               class="input input-bordered">
                        @error('serial_number')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('รายละเอียด') }}</span>
                        </label>
                        <textarea wire:model="detail" class="textarea h-24 textarea-bordered"
                                  placeholder="{{ __('รายละเอียด') }}"></textarea>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-100 text-right">
                    <button type="button" wire:click="$toggle('showingEquipmentUpdate')" class="btn btn-ghost ml-auto">
                        {{ __('ยกเลิก') }}
                    </button>
                    <button type="submit" class="btn btn-success ml-2">{{ __('บันทึก') }}</button>
                </div>
            </form>
        </x-jet-modal>

        <!-- Deletion -->
        <x-jet-confirmation-modal wire:model="confirmingEquipmentDeletion">
            <x-slot name="title">
                {{ sprintf('ลบ %s ?', optional($selected)->name) }}
                <span class="badge badge-error">{{ optional($selected)->id }}</span>
            </x-slot>

            <x-slot name="content">
                {{ sprintf('ต้องการที่จะลบ %s หรือไม่?', optional($selected)->name) }}

                @if (optional($selected)->claims && $selected->claims->isNotEmpty())
                    <div class="mt-3">{{ __('ประวัติการเคลม') }}</div>
                    <ul>
                        @each('components.li', $selected->claims->map(function($i){return"$i->id : $i->problem";}), 'slot')
                    </ul>
                @endif
            </x-slot>

            <x-slot name="footer">
                <button wire:click="$toggle('confirmingEquipmentDeletion')" class="btn btn-ghost ml-auto">
                    {{ __('ยกเลิก') }}
                </button>
                <button class="btn btn-error ml-2" wire:click="deleteEquipment" wire:loading.attr="disabled">
                    {{ __('ลบ') }}
                </button>
            </x-slot>
        </x-jet-confirmation-modal>
    </div>
</div>
