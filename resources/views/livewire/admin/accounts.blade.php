<div>
    <div class="py-12">
        <div class="tabs max-w-7xl mx-auto lg:px-8">
            <a href="{{ route('admin.claims') }}" class="tab tab-lifted">
                {{ __('รายการเคลมอุปกรณ์') }}
            </a>
            <a href="{{ route('admin.equipments') }}" class="tab tab-lifted">
                {{ __('รายการอุปกรณ์') }}
            </a>
            <a href="{{ route('admin.departments') }}" class="tab tab-lifted">
                {{ __('หน่วยงานและแผนก') }}
            </a>
            <a href="{{ route('admin.accounts') }}" class="tab tab-lifted tab-active">
                {{ __('จัดการบัญชีผู้ใช้และแอดมิน') }}
            </a>
        </div>

        <div class="max-w-7xl sm:rounded-lg bg-white mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:py-6 lg:py-8 px-0">
                <div class="flex-none lg:flex mb-3">
                    {{--
                    <div class="form-control w-full mr-2">
                        <input type="text" wire:model="search" placeholder="ค้นหา" class="input input-bordered">
                    </div>
                    <button wire:click="showCreate" class="btn btn-success ml-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="transform rotate-45 inline-block w-6 h-6 mr-2 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        {{ __('เพิ่ม') }}
                    </button>
                    --}}
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-compact border w-full table-zebra">
                        <thead>
                        <tr>
                            <th>
                                <span class="hidden lg:block">{{__('ไอดี')}}</span>
                            </th>
                            <th>{{__('ชื่อ')}}</th>
                            <th>{{__('ยศ')}}</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($accounts as $account)
                            <tr>
                                <th>{{ $account->id }}</th>
                                <td class="w-full">{{ $account->fullname }}</td>
                                <td>
                                    <div data-tip="เปลี่ยนเป็น {{ $account->isAdmin() ? 'ผู้ใช้ทั่วไป' : 'ผู้ดูแลระบบ' }}" class="tooltip tooltip-left tooltip-success">
                                        <button class="btn btn-ghost" wire:click="promotePrompt({{ $account->id }}, '{{ $account->isAdmin() ? 'member' : 'admin' }}')">
                                            {{ $account->isAdmin() ? 'ผู้ดูแลระบบ' : 'ผู้ใช้ทั่วไป' }}
                                        </button>
                                    </div>
                                </td>
                                <td>{{ $account->subDepartment->name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <x-jet-dialog-modal wire:model="showingPromotePromptDialog">
            <x-slot name="title">{{ __('เตือน') }}</x-slot>

            <x-slot name="content">
                {{ __('กรุณาใส่รหัสผ่านเพื่อยืนยันการเปลี่ยนบัญชี :user เป็นผู้ดูแลระบบ.', ['user' => session('user.fullname', '')]) }}

                <div class="mt-4" x-data="{}"
                     x-on:confirming-promote-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <input type="password" class="input input-bordered w-3/4 mt-1 block"
                           placeholder="{{ __('รหัสผ่าน') }}"
                           x-ref="password"
                           wire:model.defer="state.confirm"
                           wire:keydown.enter="promotePromptAccept"/>

                    <x-jet-input-error for="confirm" class="mt-2"/>
                </div>
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-ghost" wire:click="$toggle('showingPromotePromptDialog')"
                        wire:loading.attr="disabled">
                    {{ __('ยกเลิก') }}
                </button>

                <button class="ml-2 btn btn-error" wire:click="promotePromptAccept" wire:loading.attr="disabled">
                    {{ __('ยืนยัน') }}
                </button>
            </x-slot>
        </x-jet-dialog-modal>

    </div>
</div>
