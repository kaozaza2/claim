<div>
    <div class="py-12">
        <div class="tabs max-w-7xl mx-auto lg:px-8">
            <a href="{{ route('admin.claims') }}" class="tab tab-lifted">
                {{ __('รายการเคลมอุปกรณ์') }}
            </a>
            <a href="{{ route('admin.equipments') }}" class="tab tab-lifted">
                {{ __('รายการอุปกรณ์') }}
            </a>
            <a href="{{ route('admin.departments') }}" class="tab tab-lifted tab-active">
                {{ __('หน่วยงานและแผนก') }}
            </a>
            @if(auth()->user()->isSuperAdmin())
                <a href="{{ route('admin.departments') }}" class="tab tab-lifted">
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
                            <th>No.</th>
                            <th>{{__('หน่วยงาน')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($departments as $department)
                            <tr>
                                <th>{{ $department->id }}</th>
                                <td class="w-full">
                                    <div>{{ $department->name }}</div>
                                </td>
                                <td>
                                    <button class="btn btn-sm" wire:click="showUpdate('{{ $department->id }}')">
                                        {{ __('แก้ไข') }}
                                    </button>
                                    <button class="btn btn-success btn-sm" wire:click="showUpdate('{{ $department->id }}')">
                                        {{ __('เพิ่มแผนก') }}
                                    </button>
                                    <button wire:click="confirmDeletion('{{ $department->id }}')" class="btn btn-sm btn-error">
                                        {{ __('ลบ') }}
                                    </button>
                                </td>
                            </tr>
                            @if($department->subs->isNotEmpty())
                                @foreach($department->subs as $sub)
                                <tr>
                                    <td></td>
                                    <td class="w-full">
                                        <span class="badge badge-success">{{__('แผนก')}}</span>
                                        {{ $sub->name }}
                                    </td>
                                    <td>
                                        <button class="btn btn-sm" wire:click="showUpdate('{{ $department->id }}')">
                                            {{ __('แก้ไข') }}
                                        </button>
                                        <button wire:click="confirmDeletion('{{ $department->id }}')" class="btn btn-sm btn-error">
                                            {{ __('ลบ') }}
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Deletion -->
        <x-jet-dialog-modal wire:model="confirmingDepartmentDeletion">
            <x-slot name="title">
                {{ Str::replaceArray(':value', ['name' => optional($selected)->name], 'ลบหน่วยงาน :value ?') }}
            </x-slot>

            <x-slot name="content">
                {{ Str::replaceArray(':value', ['name' => optional($selected)->name], 'ต้องการที่จะลบหน่วยงาน :value หรือไม่?') }}

                @if(optional($selected)->subs && $selected->subs->isNotEmpty())
                    <p class="mt-3">{{ __('แผนกที่จะถูกลบไปด้วย') }}</p>
                    <ul>
                        @each('components.li', $selected->subs->pluck('name'), 'slot')
                    </ul>
                @endif
            </x-slot>

            <x-slot name="footer">
                <button wire:click="$toggle('confirmingDepartmentDeletion')" class="btn btn-ghost bg-white ml-auto">
                    {{ __('ยกเลิก') }}
                </button>
                <button class="btn btn-error ml-2" wire:click="deleteDepartment" wire:loading.attr="disabled">
                    {{ __('ลบ') }}
                </button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
