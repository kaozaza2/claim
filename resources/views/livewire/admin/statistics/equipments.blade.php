<div>
    <x-jet-confirmation-modal wire:model="showing">
        <x-slot name="title">{{ __('app.download') }}</x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="download">
                @csrf

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">{{ __('app.sub-department') }}</span>
                    </label>
                    <select wire:model.defer="state.sub"
                        @class(['input', 'input-bordered', 'input-error' => $errors->has('state.sub')])>
                        @foreach($departments as $dep)
                            <optgroup label="{{ $dep }}">
                                @foreach ($dep->subs as $sub)
                                    <option value="{{ $sub->id }}">{{ $sub }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">{{ __('app.take') }}</span>
                    </label>
                    <input type="number" wire:model.defer="state.take" min="1"
                        @class(['input', 'input-bordered', 'input-error' => $errors->has('state.take')])>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">{{ __('app.skip') }}</span>
                    </label>
                    <input type="number" wire:model.defer="state.skip" min="0"
                        @class(['input', 'input-bordered', 'input-error' => $errors->has('state.skip')])>
                </div>

                <div class="form-control">
                    <label class="cursor-pointer label">
                        <span x-text="$wire.get('state.latest') ? 'ใหม่สุด' : 'เก่าสุด'" class="label-text"></span>
                        <input type="checkbox" wire:model.lazy="state.latest" class="toggle toggle-primary">
                    </label>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-ghost" wire:click="$toggle('showing')" wire:loading.attr="disabled">
                {{ __('app.cancel') }}
            </button>

            <button class="ml-2 btn btn-success" wire:click="download" wire:loading.attr="disabled">
                {{ __('app.download') }}
            </button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
