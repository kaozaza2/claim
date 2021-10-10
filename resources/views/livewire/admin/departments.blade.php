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
                                    <button class="btn btn-success btn-sm" wire:click="showSubCreate('{{ $department->id }}')">
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
                                        <button class="btn btn-sm" wire:click="showSubUpdate('{{ $department->id }}')">
                                            {{ __('แก้ไข') }}
                                        </button>
                                        <button wire:click="confirmSubDeletion('{{ $sub->id }}')" class="btn btn-sm btn-error">
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

        <!-- Show Create -->
        <x-jet-modal wire:model="showingDepartmentCreate">
            <form wire:submit.prevent="storeDepartment">
                <div class="p-5">
                    @csrf
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('ชื่อหน่วยงาน') }}</span>
                        </label>
                        <input type="text" wire:model="name" placeholder="{{ __('ชื่อหน่วยงาน') }}"
                               class="input input-bordered">
                        @error('name')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-100 text-right">
                    <button type="button" wire:click="$toggle('showingDepartmentCreate')" class="btn btn-ghost ml-auto">
                        {{ __('ยกเลิก') }}
                    </button>
                    <button type="submit" class="btn btn-success ml-2">{{ __('บันทึก') }}</button>
                </div>
            </form>
        </x-jet-modal>

        <!-- Show Sub Create -->
        <x-jet-modal wire:model="showingSubDepartmentCreate">
            <form wire:submit.prevent="storeSubDepartment">
                <div class="p-5">
                    @csrf
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('ชื่อแผนก') }}</span>
                        </label>
                        <input type="text" wire:model="name" placeholder="{{ __('ชื่อแผนก') }}"
                               class="input input-bordered">
                        @error('name')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-100 text-right">
                    <button type="button" wire:click="$toggle('showingSubDepartmentCreate')" class="btn btn-ghost ml-auto">
                        {{ __('ยกเลิก') }}
                    </button>
                    <button type="submit" class="btn btn-success ml-2">{{ __('บันทึก') }}</button>
                </div>
            </form>
        </x-jet-modal>

        <!-- Show Update -->
        <x-jet-modal wire:model="showingDepartmentUpdate">
            <form wire:submit.prevent="updateDepartment">
                <div class="p-5">
                    @csrf
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('ชื่อหน่วยงาน') }}</span>
                        </label>
                        <input type="text" wire:model="name" placeholder="{{ __('ชื่อหน่วยงาน') }}"
                               class="input input-bordered">
                        @error('name')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-100 text-right">
                    <button type="button" wire:click="$toggle('showingDepartmentUpdate')" class="btn btn-ghost ml-auto">
                        {{ __('ยกเลิก') }}
                    </button>
                    <button type="submit" class="btn btn-success ml-2">{{ __('บันทึก') }}</button>
                </div>
            </form>
        </x-jet-modal>

        <!-- Show Sub Update -->
        <x-jet-modal wire:model="showingSubDepartmentUpdate">
            <form wire:submit.prevent="updateSubDepartment">
                <div class="p-5">
                    @csrf
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('ชื่อแผนก') }}</span>
                        </label>
                        <input type="text" wire:model="name" placeholder="{{ __('ชื่อแผนก') }}"
                               class="input input-bordered">
                        @error('name')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-100 text-right">
                    <button type="button" wire:click="$toggle('showingSubDepartmentUpdate')" class="btn btn-ghost ml-auto">
                        {{ __('ยกเลิก') }}
                    </button>
                    <button type="submit" class="btn btn-success ml-2">{{ __('บันทึก') }}</button>
                </div>
            </form>
        </x-jet-modal>

        <!-- Deletion -->
        <x-jet-dialog-modal wire:model="confirmingDepartmentDeletion">
            <x-slot name="title">
                {{ sprintf('ลบหน่วยงาน %s ?', optional($selected)->name) }}
            </x-slot>

            <x-slot name="content">
                {{ sprintf('ต้องการที่จะลบหน่วยงาน %s หรือไม่?', optional($selected)->name}}

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

        <!-- Sub Deletion -->
        <x-jet-dialog-modal wire:model="confirmingSubDepartmentDeletion">
            <x-slot name="title">
                {{ sprintf('ลบแผนก %s ?', optional($subSelected)->name) }}
            </x-slot>

            <x-slot name="content">
                {{ sprintf('ต้องการที่จะลบแผนก %s หรือไม่?', optional($subSelected)->name) }}
            </x-slot>

            <x-slot name="footer">
                <button wire:click="$toggle('confirmingSubDepartmentDeletion')" class="btn btn-ghost bg-white ml-auto">
                    {{ __('ยกเลิก') }}
                </button>
                <button class="btn btn-error ml-2" wire:click="deleteSubDepartment" wire:loading.attr="disabled">
                    {{ __('ลบ') }}
                </button>
            </x-slot>
        </x-jet-dialog-modal>

        <!-- Error -->
        <x-jet-confirmation-modal wire:model="showingErrorMessage">
            <x-slot name="title">
                {{ __('ข้อผิดพลาด') }}
            </x-slot>

            <x-slot name="content">
                {{ $errorMessage }}
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-ghost" wire:click="$toggle('showingErrorMessage')">
                    {{ __('ปิด') }}
                </button>
            </x-slot>
        </x-jet-confirmation-modal>
    </div>
</div>
