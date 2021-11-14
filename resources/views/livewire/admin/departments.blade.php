<div>
    <div class="py-12">
        <div class="tabs max-w-7xl mx-auto lg:px-8">
            <a href="{{ route('admin.claims') }}" class="tab tab-lifted">
                {{ __('app.tab.claims') }}
            </a>
            <a href="{{ route('admin.equipments') }}" class="tab tab-lifted">
                {{ __('app.tab.equipments') }}
            </a>
            <a href="{{ route('admin.departments') }}" class="tab tab-lifted tab-active">
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
                            <th>{{ __('app.number') }}</th>
                            <th>{{ __('app.department') }}</th>
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
                                        {{ __('app.edit') }}
                                    </button>
                                    <button class="btn btn-success btn-sm" wire:click="showSubCreate('{{ $department->id }}')">
                                        {{ __('app.sub-departments.add') }}
                                    </button>
                                    <button wire:click="confirmDeletion('{{ $department->id }}')" class="btn btn-sm btn-error">
                                        {{ __('app.delete') }}
                                    </button>
                                </td>
                            </tr>
                            @if($department->subs->isNotEmpty())
                                @foreach($department->subs as $sub)
                                <tr>
                                    <td></td>
                                    <td class="w-full">
                                        <span class="badge badge-success">{{__('app.sub-department')}}</span>
                                        {{ $sub->name }}
                                    </td>
                                    <td>
                                        <button class="btn btn-sm" wire:click="showSubUpdate('{{ $sub->id }}')">
                                            {{ __('app.edit') }}
                                        </button>
                                        <button wire:click="confirmSubDeletion('{{ $sub->id }}')" class="btn btn-sm btn-error">
                                            {{ __('app.delete') }}
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
                            <span class="label-text">{{ __('app.departments.name') }}</span>
                        </label>
                        <input type="text" wire:model.defer="state.name" placeholder="{{ __('app.departments.name') }}"
                               class="input input-bordered">
                        <x-jet-input-error for="name" class="text-error label-text-alt" />
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-100 text-right">
                    <button type="button" wire:click="$toggle('showingDepartmentCreate')" class="btn btn-ghost ml-auto">
                        {{ __('app.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-success ml-2" wire:loading.attr="disabled">{{ __('app.save') }}</button>
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
                            <span class="label-text">{{ __('app.sub-departments.name') }}</span>
                        </label>
                        <input type="text" wire:model.defer="state.name" placeholder="{{ __('app.sub-departments.name') }}"
                               class="input input-bordered">
                        <x-jet-input-error for="name" class="text-error label-text-alt" />
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-100 text-right">
                    <button type="button" wire:click="$toggle('showingSubDepartmentCreate')" class="btn btn-ghost ml-auto">
                        {{ __('app.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-success ml-2" wire:loading.attr="disabled">{{ __('app.save') }}</button>
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
                            <span class="label-text">{{ __('app.departments.name') }}</span>
                        </label>
                        <input type="text" wire:model.defer="state.name" placeholder="{{ __('app.departments.name') }}"
                               class="input input-bordered">
                        <x-jet-input-error for="name" class="text-error label-text-alt" />
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-100 text-right">
                    <button type="button" wire:click="$toggle('showingDepartmentUpdate')" class="btn btn-ghost ml-auto">
                        {{ __('app.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-success ml-2" wire:loading.attr="disabled">{{ __('app.save') }}</button>
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
                            <span class="label-text">{{ __('app.sub-departments.name') }}</span>
                        </label>
                        <input type="text" wire:model.defer="state.name" placeholder="{{ __('ชื่อแผนก') }}"
                               class="input input-bordered">
                        <x-jet-input-error for="name" class="text-error label-text-alt" />
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-100 text-right">
                    <button type="button" wire:click="$toggle('showingSubDepartmentUpdate')" class="btn btn-ghost ml-auto">
                        {{ __('app.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-success ml-2" wire:loading.attr="disabled">{{ __('app.save') }}</button>
                </div>
            </form>
        </x-jet-modal>

        <!-- Deletion -->
        <x-jet-dialog-modal wire:model="confirmingDepartmentDeletion">
            <x-slot name="title">
                {{ __('app.modal.title-delete', ['name' => optional($this->department)->name]) }}
            </x-slot>

            <x-slot name="content">
                {{ __('app.modal.msg-delete', ['name' => optional($this->department)->name]) }}

                @if(optional($this->department)->subs() && optional($this->department)->subs()->exists())
                    <p class="mt-3">{{ __('app.sub-departments.also') }}</p>
                    <ul>
                        @each('components.li', $this->department->subs->pluck('name'), 'slot')
                    </ul>
                @endif
            </x-slot>

            <x-slot name="footer">
                <button wire:click="$toggle('confirmingDepartmentDeletion')" class="btn btn-ghost bg-white ml-auto">
                    {{ __('app.cancel') }}
                </button>
                <button class="btn btn-error ml-2" wire:click="deleteDepartment" wire:loading.attr="disabled">
                    {{ __('app.delete') }}
                </button>
            </x-slot>
        </x-jet-dialog-modal>

        <!-- Sub Deletion -->
        <x-jet-dialog-modal wire:model="confirmingSubDepartmentDeletion">
            <x-slot name="title">
                {{ __('app.modal.title-delete', ['name' => optional($this->sub_department)->name]) }}
            </x-slot>

            <x-slot name="content">
                {{ __('app.modal.msg-delete', ['name' => optional($this->sub_department)->name]) }}
            </x-slot>

            <x-slot name="footer">
                <button wire:click="$toggle('confirmingSubDepartmentDeletion')" class="btn btn-ghost bg-white ml-auto">
                    {{ __('app.cancel') }}
                </button>
                <button class="btn btn-error ml-2" wire:click="deleteSubDepartment" wire:loading.attr="disabled">
                    {{ __('app.delete') }}
                </button>
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
