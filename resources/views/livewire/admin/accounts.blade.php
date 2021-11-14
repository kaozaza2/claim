<div>
    <div class="py-12">
        <div class="tabs max-w-7xl mx-auto lg:px-8">
            <a href="{{ route('admin.claims') }}" class="tab tab-lifted">
                {{ __('app.tab.claims') }}
            </a>
            <a href="{{ route('admin.equipments') }}" class="tab tab-lifted">
                {{ __('app.tab.equipments') }}
            </a>
            <a href="{{ route('admin.departments') }}" class="tab tab-lifted">
                {{ __('app.tab.departments') }}
            </a>
            <a href="{{ route('admin.accounts') }}" class="tab tab-lifted tab-active">
                {{ __('app.tab.accounts') }}
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
                        {{ __('app.add') }}
                    </button>
                    --}}
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-compact border w-full table-zebra">
                        <thead>
                        <tr>
                            <th>
                                <span class="hidden lg:block">{{__('app.id')}}</span>
                            </th>
                            <th>{{__('app.name')}}</th>
                            <th class="text-center">{{__('app.role')}}</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($accounts as $account)
                            <tr>
                                <th>{{ $account->id }}</th>
                                <td class="w-full">{{ $account->fullname }}</td>
                                <td>
                                    <div data-tip="{{ trans_choice('app.choice.tip-role', !$account->isAdmin()) }}" class="w-full tooltip">
                                        <button class="btn btn-sm btn-ghost" wire:click="promotePrompt({{ $account->id }}, '{{ $account->isAdmin() ? 'member' : 'admin' }}')">
                                            {{ trans_choice('app.choice.role', $account->isAdmin()) }}
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
            <x-slot name="title">{{ __('app.modal.title-warning') }}</x-slot>

            <x-slot name="content">
                {{ __('app.modal.confirm-role', ['user' => session('user.fullname', '')]) }}

                <div class="mt-4" x-data="{}"
                     x-on:confirming-promote-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <input type="password" class="input input-bordered w-full lg:w-3/4 mt-1 block"
                           placeholder="{{ __('app.password') }}"
                           x-ref="password"
                           wire:model.defer="state.confirm"
                           wire:keydown.enter="promotePromptAccept"/>

                    <x-jet-input-error for="confirm" class="mt-2"/>
                </div>
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-ghost" wire:click="$toggle('showingPromotePromptDialog')"
                        wire:loading.attr="disabled">
                    {{ __('app.cancel') }}
                </button>

                <button class="ml-2 btn btn-error" wire:click="promotePromptAccept" wire:loading.attr="disabled">
                    {{ __('app.confirm') }}
                </button>
            </x-slot>
        </x-jet-dialog-modal>

    </div>
</div>
