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
                                <td class="w-full">
                                    {{ $account }}
                                    @if ($account->is(auth()->user()))
                                        <div class="badge badge-success">{{ __('app.you') }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if (!$account->is(auth()->user()))
                                    <div data-tip="{{ __('app.roles.switch.'.($account->isAdmin() ? 'member' : 'admin')) }}"
                                         class="w-full tooltip">
                                        <button class="btn btn-sm btn-ghost" wire:click="promotePrompt({{ $account->id }})">
                                            {{ __('app.roles.'.$account->role) }}
                                        </button>
                                    </div>
                                    @else
                                    <div class="btn btn-sm btn-ghost no-animation">
                                        {{ __('app.roles.'.$account->role) }}
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm" wire:click="showUpdateUserDialog({{ $account->id }})">
                                        {{ __('app.edit') }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <x-jet-confirmation-modal wire:model="showingPromotePromptDialog">
            <x-slot name="title">
                {{ __('app.modal.title-warning') }}
            </x-slot>

            <x-slot name="content">
                <p>{{
                  __('app.modal.msg-confirm-role', [
                      'user' => session('user.fullname'),
                      'role' => __('app.roles.'.(session('user.role') != 'admin' ? 'admin' : 'member')),
                  ])
                }}</p>

                @if (session('user.role') != 'admin')
                <div class="mt-4" x-data="{}"
                     x-on:confirming-promote-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <input type="password" class="input input-bordered w-full lg:w-3/4 mt-1 block"
                           placeholder="{{ __('app.password') }}"
                           x-ref="password"
                           wire:model.defer="state.confirm"
                           wire:keydown.enter="promotePromptAccept"/>

                    <x-jet-input-error for="confirm" hint="{{ __('app.modal.msg-confirm-role-extra') }}" />
                </div>
                @endif
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
        </x-jet-confirmation-modal>

        <x-jet-modal wire:model="showingUpdateUserDialog">
            <form wire:submit.prevent="updateUserInformation">
                <div class="p-5">
                    @csrf
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.users.title') }}</span>
                        </label>
                        <input type="text" class="input input-bordered" wire:model.defer="state.user.title"
                               placeholder="{{ __('app.users.title') }}">
                        <x-jet-input-error for="title" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.users.name') }}</span>
                        </label>
                        <input type="text" class="input input-bordered" wire:model.defer="state.user.name"
                               placeholder="{{ __('app.users.name') }}">
                        <x-jet-input-error for="name" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.users.lastname') }}</span>
                        </label>
                        <input type="text" class="input input-bordered" wire:model.defer="state.user.last_name"
                               placeholder="{{ __('app.users.lastname') }}">
                        <x-jet-input-error for="last_name" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.users.sex') }}</span>
                        </label>
                        <select class="select select-bordered w-full max-w-xs" wire:model.defer="state.user.sex">
                            @foreach (\App\Models\User::sexes() as $key => $sex)
                                <option value="{{ $key }}">{{ __('app.users.sexes.'.$sex) }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="sex" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.users.identification') }}</span>
                        </label>
                        <input type="text" class="input input-bordered" wire:model.defer="state.user.identification"
                               placeholder="{{ __('app.users.identification') }}">
                        <x-jet-input-error for="identification" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.users.username') }}</span>
                        </label>
                        <div data-tip="{{ __('app.modal.msg-warn-username-change') }}" class="w-full tooltip">
                            <input type="text" class="w-full input input-bordered" wire:model.defer="state.user.username"
                                   placeholder="{{ __('app.users.username') }}">
                        </div>
                        <x-jet-input-error for="username" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.users.email') }}</span>
                        </label>
                        <input type="text" class="input input-bordered" wire:model.defer="state.user.email"
                               placeholder="{{ __('app.users.email') }}">
                        <x-jet-input-error for="email" class="text-error label-text-alt" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ __('app.sub-department') }}</span>
                        </label>
                        <select class="select select-bordered w-full max-w-xs"
                                wire:model.defer="state.user.sub_department_id">
                            @foreach (\App\Models\Department::has('subs')->get() as $dep)
                                <optgroup label="{{ $dep }}">
                                    @foreach ($dep->subs as $sub)
                                        <option value="{{ $sub->id }}">{{ $sub }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <x-jet-input-error for="sub_department_id" class="text-error label-text-alt" />
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-100 text-right">
                    <div wire:click="$toggle('showingUpdateUserDialog')" class="btn btn-ghost" wire:loading.attr="disabled">
                        {{ __('app.cancel') }}
                    </div>

                    <button type="submit" class="ml-2 btn btn-success" wire:loading.attr="disabled">
                        {{ __('app.save') }}
                    </button>
                </div>
            </form>
        </x-jet-modal>
    </div>
</div>
