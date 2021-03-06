<div>
    <div class="py-6">
        @livewire('admin-tab')

        <x-layout-box>
            <div class="flex-none lg:flex mb-3">
                <div class="form-control w-full mr-2">
                    <input type="text" wire:model.lazy="search" placeholder="{{ __('app.search') }}"
                           class="input input-bordered">
                </div>
                <button wire:click="$emitSelf('claim-table-create')" class="btn btn-success ml-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         class="transform rotate-45 inline-block w-6 h-6 mr-2 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    {{ __('app.add') }}
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="table table-compact border w-full table-zebra">
                    <thead>
                    <tr>
                        <th>
                            <span class="hidden lg:block"> {{ __('app.claims.id') }}</span>
                        </th>
                        <th> {{ __('app.equipment') }}</th>
                        <th> {{ __('app.equipments.type') }}</th>
                        <th> {{ __('app.equipments.serial') }}</th>
                        <th> {{ __('app.claims.problem') }}</th>
                        <th> {{ __('app.claims.applicant') }}</th>
                        <th> {{ __('app.claims.recipient') }}</th>
                        <th> {{ __('app.status') }}</th>
                        <th> {{ __('app.claims.claimed') }}</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($claims as $key => $claim)
                        <tr>
                            <th>{{ $claim->id }}</th>
                            <td>
                                <div wire:click="$emit('show-equipment-detail', {{ $claim->equipment->id }})"
                                     class="px-1 my-0 rounded-sm btn btn-sm btn-ghost no-animation">
                                    {{ $claim->equipment }}
                                </div>
                            </td>
                            <td>{{ $claim->equipment->category }}</td>
                            <td class="font-mono">{{ $claim->equipment->serial_number ?: '-' }}</td>
                            <td>
                                <div class="block whitespace-normal w-40">
                                    <p class="break-words">{{ $claim->problem }}</p>
                                </div>
                            </td>
                            <td>{{ $claim->user->fullname }}</td>
                            <td>{{ $claim->admin->fullname }}</td>
                            <td>{{ $claim->status }}</td>
                            <td class="text-center">
                                <div data-tip="{{ __('app.claims.mark-claimed') }}" class="w-full tooltip">
                                    <input type="checkbox" class="checkbox checkbox-accent"
                                           @if ($claim->complete) checked="checked" @endif
                                           wire:click="$emitSelf('claim-table-toggle', {{ $key }})"/>
                                </div>
                            </td>
                            <td>
                                <button wire:click="$emitSelf('claim-table-update', {{ $key }})" class="btn btn-sm">
                                    {{ __('app.edit') }}
                                </button>
                                <button wire:click="$emitSelf('claim-table-delete', {{ $key }})" class="btn btn-sm btn-error">
                                    {{ __('app.delete') }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </x-layout-box>

        <!-- Show Create -->
        <x-jet-modal wire:model="showingClaimCreate">
            <form wire:submit.prevent="store">
                @csrf
                <div class="p-5">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">{{ __('app.equipment') }}</span>
                        </label>
                        <select wire:model.defer="state.equipment_id" class="select select-bordered w-full">
                            @foreach($equipments as $equipment)
                                <option value="{{ $equipment->id }}">
                                    [{{ $equipment->id }}] {{ $equipment }} : {{ $equipment->serial_number }}
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
                            <span class="label-text">{{ __('app.claims.problem') }}</span>
                        </label>
                        <textarea wire:model.defer="state.problem" class="textarea h-24 textarea-bordered"
                                  placeholder="{{ __('app.details') }}"></textarea>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.claims.applicant') }}</span>
                        </label>
                        <select wire:model.defer="state.user_id" class="select select-bordered w-full">
                            @foreach($users->where('role', 'member') as $user)
                                <option value="{{ $user->id }}">{{ $user }}</option>
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
                            <span class="label-text">{{ __('app.claims.recipient') }}</span>
                        </label>
                        <select wire:model.defer="state.admin_id" class="select select-bordered w-full">
                            @foreach($users->where('role', 'admin') as $admin)
                                <option value="{{ $admin->id }}">{{ $admin }}</option>
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
                        <select wire:model.defer="state.status" class="select select-bordered w-full">
                            @foreach($claim_status as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
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
            <form wire:submit.prevent="update">
                @csrf
                <div class="p-5">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">{{ __('app.equipment') }}</span>
                        </label>
                        <select wire:model.defer="state.equipment_id" class="select select-bordered w-full">
                            @foreach($equipments as $equipment)
                                <option value="{{ $equipment->id }}">
                                    [{{ $equipment->id }}] {{ $equipment }} : {{ $equipment->serial_number }}
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
                            <span class="label-text">{{ __('app.claims.problem') }}</span>
                        </label>
                        <textarea wire:model.defer="state.problem" class="textarea h-24 textarea-bordered"
                                  placeholder="{{ __('app.details') }}"></textarea>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.claims.applicant') }}</span>
                        </label>
                        <select wire:model.defer="state.user_id" class="select select-bordered w-full">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user }}</option>
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
                            <span class="label-text">{{ __('app.claims.recipient') }}</span>
                        </label>
                        <select wire:model.defer="state.admin_id" class="select select-bordered w-full">
                            @foreach($users->where('role', 'admin') as $admin)
                                <option value="{{ $admin->id }}">{{ $admin }}</option>
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
                        <select wire:model.defer="state.status" class="select select-bordered w-full">
                            @foreach($claim_status as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
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
                    <button type="submit" class="btn btn-success ml-2">{{ __('??????????????????') }}</button>
                </div>
            </form>
        </x-jet-modal>
    </div>
</div>
