<div>
    <x-jet-modal wire:model="showingTransferReport">
        <form wire:submit.prevent="storeTransfer">
            @csrf
            <div class="p-5">
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">{{ __('อุปกรณ์') }}</span>
                    </label>
                    <select wire:model="equipment_id" class="select select-bordered w-full">
                        <option disabled="disabled" selected="selected">{{ __('เลือก') }}</option>
                        @foreach($equipments as $e)
                            <option value="{{ $e->id }}">{{ sprintf('%s : %s : %s : %s', $e->name, $e->brand, $e->category, $e->serial_number) }}</option>
                        @endforeach
                    </select>
                    @error('equipment_id')
                    <label class="label">
                        <span class="text-error label-text-alt">{{ $message }}</span>
                    </label>
                    @enderror
                </div>
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">{{ __('แผนกที่จะย้าย') }}</span>
                    </label>
                    <select wire:model="to_sub_department_id" class="select select-bordered w-full">
                        @foreach($subDepartments as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                    @error('to_sub_department_id')
                    <label class="label">
                        <span class="text-error label-text-alt">{{ $message }}</span>
                    </label>
                    @enderror
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-100 text-right">
                <button type="button" wire:click="$toggle('showingTransferReport')" class="btn btn-ghost ml-auto">
                    {{ __('ยกเลิก') }}
                </button>
                <button type="submit" class="btn btn-success ml-2">{{ __('บันทึก') }}</button>
            </div>
        </form>
    </x-jet-modal>
</div>
