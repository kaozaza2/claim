<div>
    <div class="py-12">
        <div class="tabs max-w-7xl mx-auto lg:px-8">
            <a href="{{ route('admin.claims') }}" class="tab tab-lifted tab-active">
                {{ __('รายการเคลมอุปกรณ์') }}
            </a>
            <a href="{{ route('admin.equipments') }}" class="tab tab-lifted">
                {{ __('รายการอุปกรณ์') }}
            </a>
            <a href="{{ route('admin.departments') }}" class="tab tab-lifted">
                {{ __('หน่วยงานและแผนก') }}
            </a>
            @if(auth()->user()->isSuperAdmin())
                <a wire:click="$emit('showAccounts')" class="tab tab-lifted">
                    {{ __('จัดการบัญชีผู้ใช้และแอดมิน') }}
                </a>
            @endif
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
                                <span class="hidden lg:block">{{__('เลขที่การเคลม')}}</span>
                            </th>
                            <th>{{__('อุปกร์ที่เคลม')}}</th>
                            <th>{{__('เลขครุภัณฑ์')}}</th>
                            <th>{{__('อาการ')}}</th>
                            <th>{{__('ผู้แจ้งเรื่อง')}}</th>
                            <th>{{__('ผู้รับเรื่อง')}}</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($claims as $claim)
                            <tr>
                                <th>{{ $claim->id }}</th>
                                <td>
                                    <button class="btn btn-sm btn-ghost capitalize" wire:click="showEquipment('{{ $claim->equipment->id }}')">
                                        {{ $claim->equipment->name }}
                                    </button>
                                </td>
                                <td class="font-mono">{{ $claim->equipment->serial_number ?: '-' }}</td>
                                <td class="w-full">{{ $claim->problem }}</td>
                                <td>{{ $claim->user->fullname }}</td>
                                <td>{{ $claim->admin->fullname }}</td>
                                <td>
                                    <button wire:click="showUpdate('{{ $claim->id }}')" class="btn btn-sm">
                                        {{ __('แก้ไข') }}
                                    </button>
                                    <button wire:click="confirmDeletion('{{ $claim->id }}')" class="btn btn-sm btn-error">
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

        <!-- Detail -->
        <x-jet-dialog-modal wire:model="showingEquipmentDetail">
            <x-slot name="title">
                {{ optional($equipment)->name }}
            </x-slot>

            <x-slot name="content">
                <img class="border mx-auto max-w-xs" src="{{ optional($equipment)->picture_url }}" alt="{{ optional($equipment)->name }}">
                <table class="mt-3 w-full">
                    <tr>
                        <th scope="col" class="border">{{ __('เลขที่อุปกรณ์') }}</th>
                        <td class="border">{{ optional($equipment)->id }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="border">{{ __('ชื่ออุปกรณ์') }}</th>
                        <td class="border">{{ optional($equipment)->name }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="border">{{ __('เลขครุภัณฑ์') }}</th>
                        <td class="border">{{ optional($equipment)->serial_number }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="border">{{ __('รายละเอียด') }}</th>
                        <td class="border">{{ optional($equipment)->detail }}</td>
                    </tr>
                </table>
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-ghost" wire:click="$toggle('showingEquipmentDetail')">
                    {{ __('ปิด') }}
                </button>
            </x-slot>
        </x-jet-dialog-modal>

        <!-- Show Create -->
        <x-jet-modal wire:model="showingClaimCreate">
            <form wire:submit.prevent="storeClaim">
                @csrf
                <div class="p-5">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">{{ __('อุปกรณ์') }}</span>
                        </label>
                        <select wire:model="equipment_id" class="select select-bordered w-full">
                            <option disabled="disabled" selected="selected">{{ __('เลือก') }}</option>
                            @foreach(\App\Models\Equipment::all() as $e)
                                <option value="{{ $e->id }}">
                                    [{{ $e->id }}] {{ $e->name }} : {{ $e->serial_number }}
                                </option>
                            @endforeach
                        </select>
                        @error('equipment_id')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('อาการที่พบ') }}</span>
                        </label>
                        <textarea wire:model="problem" class="textarea h-24 textarea-bordered" placeholder="{{ __('รายละเอียด') }}"></textarea>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('ผู้แจ้งเคลม') }}</span>
                        </label>
                        <select wire:model="user_id" class="select select-bordered w-full">
                            @foreach(\App\Models\User::member()->cursor() as $e)
                                <option value="{{ $e->id }}">{{ $e->fullname }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('ผู้รับเรื่อง') }}</span>
                        </label>
                        <select wire:model="admin_id" class="select select-bordered w-full">
                            @if(auth()->user()->isSuperAdmin())
                                @foreach(\App\Models\User::admin()->cursor() as $e)
                                    <option value="{{ $e->id }}">{{ $e->fullname }}</option>
                                @endforeach
                            @else
                                <option value="{{ auth()->user()->id }}">{{ auth()->user()->fullname }}</option>
                            @endif
                        </select>
                        @error('admin_id')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('สถานะ') }}</span>
                        </label>
                        <input type="text" wire:model="status" class="input input-bordered"
                               placeholder="{{__('สถานะ')}}">
                        @error('status')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-100 text-right">
                    <button type="button" wire:click="$toggle('showingClaimCreate')" class="btn btn-ghost ml-auto">
                        {{ __('ยกเลิก') }}
                    </button>
                    <button type="submit" class="btn btn-success ml-2">{{ __('บันทึก') }}</button>
                </div>
            </form>
        </x-jet-modal>

        <!-- Update -->
        <x-jet-modal wire:model="showingClaimUpdate">
            <form wire:submit.prevent="updateClaim">
                @csrf
                <div class="p-5">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">{{ __('อุปกรณ์') }}</span>
                        </label>
                        <select wire:model="equipment_id" class="select select-bordered w-full">
                            @foreach(\App\Models\Equipment::all() as $e)
                                <option value="{{ $e->id }}">
                                    [{{ $e->id }}] {{ $e->name }} : {{ $e->serial_number }}
                                </option>
                            @endforeach
                        </select>
                        @error('equipment_id')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('อาการที่พบ') }}</span>
                        </label>
                        <textarea wire:model="problem" class="textarea h-24 textarea-bordered" placeholder="{{ __('รายละเอียด') }}"></textarea>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('ผู้แจ้งเคลม') }}</span>
                        </label>
                        <select wire:model="user_id" class="select select-bordered w-full">
                            @foreach(\App\Models\User::member()->cursor() as $e)
                                <option value="{{ $e->id }}">{{ $e->fullname }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('ผู้รับเรื่อง') }}</span>
                        </label>
                        <select wire:model="admin_id" class="select select-bordered w-full">
                            @if(auth()->user()->isSuperAdmin())
                                @foreach(\App\Models\User::admin()->cursor() as $e)
                                    <option value="{{ $e->id }}">{{ $e->fullname }}</option>
                                @endforeach
                            @elseif ($selected)
                                <option value="{{ $selected->admin->id }}">{{ $selected->admin->fullname }}</option>
                            @endif
                        </select>
                        @error('admin_id')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('สถานะ') }}</span>
                        </label>
                        <input type="text" wire:model="status" class="input input-bordered"
                               placeholder="{{__('สถานะ')}}">
                        @error('status')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-100 text-right">
                    <button type="button" wire:click="$toggle('showingClaimUpdate')" class="btn btn-ghost ml-auto">
                        {{ __('ยกเลิก') }}
                    </button>
                    <button type="submit" class="btn btn-success ml-2">{{ __('บันทึก') }}</button>
                </div>
            </form>
        </x-jet-modal>

        <!-- Delete -->
        <x-jet-confirmation-modal wire:model="confirmingClaimDeletion">
            <x-slot name="title">
                {{ __('ลบรายการเคลม') }}
            </x-slot>

            <x-slot name="content">
                {{ sprintf('ต้องการที่จะลบรายการเคลม %s หรือไม่?', optional($selected)->id) }}
            </x-slot>

            <x-slot name="footer">
                <button type="button" wire:click="$toggle('confirmingClaimDeletion')" class="btn btn-ghost ml-auto">
                    {{ __('ยกเลิก') }}
                </button>
                <button type="submit" wire:click="deleteClaim" class="btn btn-error ml-2">
                    {{ __('ลบ') }}
                </button>
            </x-slot>
        </x-jet-confirmation-modal>
    </div>
</div>
