<div>
    <x-jet-modal wire:model="showingClaimReport">
        <form wire:submit.prevent="storePreClaim">
            @csrf
            <div class="p-5">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">{{ __('อุปกรณ์') }}</span>
                    </label>
                    <select wire:model="equipment_id" class="select select-bordered w-full">
                        <option disabled="disabled" selected="selected">{{ __('เลือก') }}</option>
                        @foreach(\App\Models\Equipment::whereSubDepartment()->cursor() as $e)
                            <option value="{{ $e->id }}">{{ $e->name }} : {{ $e->serial_number }}</option>
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
                        <span class="label-text">{{ __('อาการที่พบ') }}</span>
                    </label>
                    <textarea wire:model="problem" class="textarea h-24 textarea-bordered" placeholder="{{ __('รายละเอียด') }}"></textarea>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-100 text-right">
                <button type="button" wire:click="$toggle('showingClaimReport')" class="btn btn-ghost ml-auto">
                    {{ __('ยกเลิก') }}
                </button>
                <button type="submit" class="btn btn-success ml-2">{{ __('บันทึก') }}</button>
            </div>
        </form>
    </x-jet-modal>
</div>
