<div>
    <div class="py-12">
        <div class="tabs max-w-7xl mx-auto lg:px-8">
            <a href="{{ route('admin.claims') }}" class="tab tab-lifted tab-active">
                {{ __('app.tab.claims') }}
            </a>
            <a href="{{ route('admin.equipments') }}" class="tab tab-lifted">
                {{ __('app.tab.equipments') }}
            </a>
            <a href="{{ route('admin.departments') }}" class="tab tab-lifted">
                {{ __('app.tab.departments') }}
            </a>
            <a href="{{ route('admin.accounts') }}" class="tab tab-lifted">
                {{ __('app.tab.accounts') }}
            </a>
        </div>

        <div class="max-w-7xl sm:rounded-lg bg-white mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:py-6 lg:py-8 px-0">
                <div class="flex-none lg:flex mb-3">
                    <div class="form-control w-full mr-2">
                        <input type="text" wire:model="search" placeholder="{{ __('app.search') }}" class="input input-bordered">
                    </div>
                    <button wire:click="showCreate" class="btn btn-success ml-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="transform rotate-45 inline-block w-6 h-6 mr-2 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        {{ __('app.add') }}
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-compact border w-full table-zebra">
                        <thead>
                        <tr>
                            <th>
                                <span class="hidden lg:block">{{__('app.claim-id')}}</span>
                            </th>
                            <th>{{__('app.equipment')}}</th>
                            <th>{{__('app.type')}}</th>
                            <th>{{__('app.serial')}}</th>
                            <th>{{__('app.problem')}}</th>
                            <th>{{__('app.applicant')}}</th>
                            <th>{{__('app.recipient')}}</th>
                            <th>{{__('app.claimed')}}</th>
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
                                <td>{{ $claim->equipment->category }}</td>
                                <td class="font-mono">{{ $claim->equipment->serial_number ?: '-' }}</td>
                                <td class="w-full">{{ $claim->problem }}</td>
                                <td>{{ $claim->user->fullname }}</td>
                                <td>{{ $claim->admin->fullname }}</td>
                                <td class="text-center">
                                    <div data-tip="{{ __('app.mark-as-claimed') }}" class="w-full tooltip">
                                        <input type="checkbox" class="checkbox checkbox-accent" @if($claim->isCompleted()) checked="checked" @endif
                                               wire:click="setCompleted({{ $claim->id }}, {{ $claim->isCompleted() ? 'false' : 'true' }})" />
                                    </div>
                                </td>
                                <td>
                                    <button wire:click="showUpdate('{{ $claim->id }}')" class="btn btn-sm">
                                        {{ __('app.edit') }}
                                    </button>
                                    <button wire:click="confirmDeletion('{{ $claim->id }}')" class="btn btn-sm btn-error">
                                        {{ __('app.delete') }}
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
                        <th scope="col" class="border">{{ __('app.claim-id') }}</th>
                        <td class="border">{{ optional($equipment)->id }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="border">{{ __('app.model') }}</th>
                        <td class="border">{{ optional($equipment)->name }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="border">{{ __('app.brand') }}</th>
                        <td class="border">{{ optional($equipment)->brand }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="border">{{ __('app.type') }}</th>
                        <td class="border">{{ optional($equipment)->category }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="border">{{ __('app.serial') }}</th>
                        <td class="border">{{ optional($equipment)->serial_number }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="border">{{ __('app.details') }}</th>
                        <td class="border">{{ optional($equipment)->detail }}</td>
                    </tr>
                </table>
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-ghost" wire:click="$toggle('showingEquipmentDetail')">
                    {{ __('app.close') }}
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
                            <span class="label-text">{{ __('app.equipment') }}</span>
                        </label>
                        <select wire:model="equipment_id" class="select select-bordered w-full">
                            <option disabled="disabled" selected="selected">{{ __('app.select') }}</option>
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
                            <span class="label-text">{{ __('app.problem') }}</span>
                        </label>
                        <textarea wire:model="problem" class="textarea h-24 textarea-bordered" placeholder="{{ __('app.details') }}"></textarea>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.applicant') }}</span>
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
                            <span class="label-text">{{ __('app.recipient') }}</span>
                        </label>
                        <select wire:model="admin_id" class="select select-bordered w-full">
                            @foreach(\App\Models\User::admin()->cursor() as $e)
                                <option value="{{ $e->id }}">{{ $e->fullname }}</option>
                            @endforeach
                        </select>
                        @error('admin_id')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.status') }}</span>
                        </label>
                        <input type="text" wire:model="status" class="input input-bordered"
                               placeholder="{{__('app.status')}}">
                        @error('status')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-100 text-right">
                    <button type="button" wire:click="$toggle('showingClaimCreate')" class="btn btn-ghost ml-auto">
                        {{ __('app.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-success ml-2">{{ __('app.save') }}</button>
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
                            <span class="label-text">{{ __('app.equipment') }}</span>
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
                            <span class="label-text">{{ __('app.problem') }}</span>
                        </label>
                        <textarea wire:model="problem" class="textarea h-24 textarea-bordered" placeholder="{{ __('app.details') }}"></textarea>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.applicant') }}</span>
                        </label>
                        <select wire:model="user_id" class="select select-bordered w-full">
                            @foreach(\App\Models\User::all() as $e)
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
                            <span class="label-text">{{ __('app.recipient') }}</span>
                        </label>
                        <select wire:model="admin_id" class="select select-bordered w-full">
                            @foreach(\App\Models\User::admin()->cursor() as $e)
                                <option value="{{ $e->id }}">{{ $e->fullname }}</option>
                            @endforeach
                        </select>
                        @error('admin_id')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.status') }}</span>
                        </label>
                        <input type="text" wire:model="status" class="input input-bordered"
                               placeholder="{{__('app.status')}}">
                        @error('status')
                        <label class="label">
                            <span class="text-error label-text-alt">{{ $message }}</span>
                        </label>
                        @enderror
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-100 text-right">
                    <button type="button" wire:click="$toggle('showingClaimUpdate')" class="btn btn-ghost ml-auto">
                        {{ __('app.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-success ml-2">{{ __('บันทึก') }}</button>
                </div>
            </form>
        </x-jet-modal>

        <!-- Delete -->
        <x-jet-confirmation-modal wire:model="confirmingClaimDeletion">
            <x-slot name="title">
                {{ __('app.modal.title-claim-delete') }}
            </x-slot>

            <x-slot name="content">
                {{ __('app.modal.msg-claim-delete', ['claim' => optional($selected)->id]) }}
            </x-slot>

            <x-slot name="footer">
                <button type="button" wire:click="$toggle('confirmingClaimDeletion')" class="btn btn-ghost ml-auto">
                    {{ __('app.cancel') }}
                </button>
                <button type="submit" wire:click="deleteClaim" class="btn btn-error ml-2">
                    {{ __('app.delete') }}
                </button>
            </x-slot>
        </x-jet-confirmation-modal>
    </div>
</div>
