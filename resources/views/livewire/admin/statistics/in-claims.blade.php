<div>
    <x-jet-confirmation-modal wire:model="showing">
        <x-slot name="title">{{ __('app.download') }}</x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="download">
                @csrf

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">{{ __('app.equipment') }}</span>
                    </label>

                    <select wire:model.defer="state.equipment"
                        @class(['input', 'input-bordered', 'input-error' => $errors->has('state.sub')])>
                        <option selected>{{ __('app.all') }}</option>
                        @foreach($equipments as $equipment)
                            <option value="{{ $equipment->id }}">{{ $equipment->full_details }}</option>
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
