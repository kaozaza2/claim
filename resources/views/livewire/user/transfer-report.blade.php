<div>
    <x-jet-modal wire:model="showing">
        <form wire:submit.prevent="store">
            @csrf
            <div class="p-5">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">{{ __('อุปกรณ์') }}</span>
                    </label>
                    <select wire:model.lazy="state.equipment" class="select select-bordered w-full">
                        @foreach ($equipments as $equipment)
                            <option value="{{ $equipment->id }}">{{ $equipment->full_details }}</option>
                        @endforeach
                    </select>
                    @error('equipment')
                    <label class="label">
                        <span class="text-error label-text-alt">{{ $message }}</span>
                    </label>
                    @enderror
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">{{ __('แผนกที่จะย้าย') }}</span>
                    </label>
                    <select wire:model.defer="state.to" class="select select-bordered w-full">
                        @foreach ($subs as $sub)
                            <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                        @endforeach
                    </select>
                    @error('to')
                    <label class="label">
                        <span class="text-error label-text-alt">{{ $message }}</span>
                    </label>
                    @enderror
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-100 text-right">
                <button type="button" wire:click="$toggle('showing')" class="btn btn-ghost ml-auto">
                    {{ __('app.cancel') }}
                </button>
                <button type="submit" class="btn btn-success ml-2">{{ __('app.save') }}</button>
            </div>
        </form>
    </x-jet-modal>
</div>
