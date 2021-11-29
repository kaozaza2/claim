<div>
    <div class="py-6">
        <div class="tabs max-w-7xl mx-auto lg:px-8">
            <a href="{{ route('admin.requests') }}" class="tab tab-bordered">
                {{ __('app.tab.requests') }}
            </a>
            <a href="{{ route('admin.claims') }}" class="tab tab-bordered">
                {{ __('app.tab.claims') }}
            </a>
            <a href="{{ route('admin.equipments') }}" class="tab tab-bordered tab-active">
                {{ __('app.tab.equipments') }}
            </a>
            <a href="{{ route('admin.departments') }}" class="tab tab-bordered">
                {{ __('app.tab.departments') }}
            </a>
            <a href="{{ route('admin.accounts') }}" class="tab tab-bordered">
                {{ __('app.tab.accounts') }}
            </a>
        </div>

        <div class="max-w-7xl sm:rounded-lg bg-white mt-6 mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:py-6 lg:py-8 px-0">
                <div class="flex-none lg:flex mb-3">
                    <div class="form-control w-full mr-2">
                        <input type="text" wire:model.lazy="search" placeholder="{{ __('app.search') }}" class="input input-bordered">
                    </div>
                    <button wire:click="$emit('admin-equipment-create')" class="btn btn-success ml-auto">
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
                        @foreach ($equipments as $key => $equipment)
                            <tr>
                                <th>{{ $equipment->id }}</th>
                                </td>
                                <td class="w-full">
                                    {{ $equipment }}
                                    <div wire:click="$emit('show-equipment-detail', {{ $equipment->id }})"
                                         class="inline-block cursor-pointer rounded-sm btn-ghost">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 0 24 24" width="14px" fill="#3d4451">
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
                                    <button class="btn btn-sm" wire:click="$emit('admin-equipment-update', {{ $key }})">
                                        {{ __('app.edit') }}
                                    </button>
                                    <button wire:click="$emit('admin-equipment-delete', {{ $key }})" class="btn btn-sm btn-error">
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

        <!-- Show Create -->
        <x-jet-modal wire:model="creating">
            <form wire:submit.prevent="store">
                <div class="p-5">
                    @csrf
                    <div class="form-control">
                        <span class="label label-text">{{ __('app.image') }}</span>
                        <label class="label input input-bordered w-full">
                            <span>{{ __('app.image.select') }}</span>
                            <input type="file" wire:model.defer="state.picture" class="hidden">
                        </label>
                        <x-jet-input-error for="picture" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.equipments.model') }}</span>
                        </label>
                        <input type="text" wire:model.defer="state.name" placeholder="{{ __('app.equipments.model') }}"
                               class="input input-bordered">
                        <x-jet-input-error for="name" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.equipments.brand') }}</span>
                        </label>
                        <input type="text" wire:model.defer="state.brand" placeholder="{{ __('app.equipments.brand') }}"
                               class="input input-bordered">
                        <x-jet-input-error for="brand" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.equipments.type') }}</span>
                        </label>
                        <input type="text" wire:model.defer="state.category" placeholder="{{ __('app.equipments.type') }}"
                               class="input input-bordered">
                        <x-jet-input-error for="category" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.equipments.serial') }}</span>
                        </label>
                        <input type="text" wire:model.defer="state.serial_number" placeholder="{{ __('app.equipments.serial') }}"
                               class="input input-bordered">
                        <x-jet-input-error for="serial_number" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.sub-department') }}</span>
                        </label>
                        <select class="select select-bordered w-full" wire:model.defer="state.sub_department_id">
                            @foreach ($subs as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="sub_department_id" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.details') }}</span>
                        </label>
                        <textarea wire:model.defer="state.detail" class="textarea h-24 textarea-bordered"
                                  placeholder="{{ __('app.details') }}"></textarea>
                        <x-jet-input-error for="detail" class="text-error label-text-alt" />
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-100 text-right">
                    <button type="button" wire:click="$toggle('creating')" class="btn btn-ghost ml-auto">
                        {{ __('app.cancel') }}
                    </button>
                    <button type="submit" wire:loading.attr="disabled" class="btn btn-success ml-2">{{ __('app.save') }}</button>
                </div>
            </form>
        </x-jet-modal>

        <!-- Show Update -->
        <x-jet-modal wire:model="updating">
            <form wire:submit.prevent="update">
                @csrf
                <div class="p-5">
                    <div class="form-control">
                        <span class="label label-text">{{ __('app.image') }}</span>
                        <label class="label input input-bordered w-full">
                            <span>{{ __('app.image.select') }}</span>
                            <input type="file" wire:model.defer="state.picture" class="hidden">
                        </label>
                        <x-jet-input-error for="picture" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.equipments.model') }}</span>
                        </label>
                        <input type="text" wire:model.defer="state.name" placeholder="{{ __('app.equipments.model') }}"
                               class="input input-bordered">
                        <x-jet-input-error for="name" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.equipments.brand') }}</span>
                        </label>
                        <input type="text" wire:model.defer="state.brand" placeholder="{{ __('app.equipments.brand') }}"
                               class="input input-bordered">
                        <x-jet-input-error for="brand" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.equipments.type') }}</span>
                        </label>
                        <input type="text" wire:model.defer="state.category" placeholder="{{ __('app.equipments.type') }}"
                               class="input input-bordered">
                        <x-jet-input-error for="category" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.equipments.serial') }}</span>
                        </label>
                        <input type="text" wire:model.defer="state.serial_number" placeholder="{{ __('app.equipments.serial') }}"
                               class="input input-bordered">
                        <x-jet-input-error for="serial_number" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.sub-department') }}</span>
                        </label>
                        <select class="select select-bordered w-full" wire:model.defer="state.sub_department_id">
                            @foreach ($subs as $sub)
                                <option value="{{ $sub->id }}">{{ $sub }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="sub_department_id" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.details') }}</span>
                        </label>
                        <textarea wire:model.defer="state.detail" class="textarea h-24 textarea-bordered"
                                  placeholder="{{ __('app.details') }}"></textarea>
                        <x-jet-input-error for="detail" class="text-error label-text-alt" />
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-100 text-right">
                    <button type="button" wire:click="$toggle('updating')" class="btn btn-ghost ml-auto">
                        {{ __('app.cancel') }}
                    </button>
                    <button type="submit"  wire:loading.attr="disabled" class="btn btn-success ml-2">{{ __('app.save') }}</button>
                </div>
            </form>
        </x-jet-modal>
    </div>
</div>
