<x-jet-form-section submit="updateDepartment">
    <x-slot name="title">
        {{ __('หน่วยงานและแผนก') }}
    </x-slot>

    <x-slot name="description">
        {{ __('จัดการหน่วยงานและแผนก') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="department" value="{{ __('หน่วยงาน') }}" />
            <select class="w-full mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    id="department" wire:model="department">
                @foreach ($departments as $dep)
                    @if ($dep->subs->isEmpty())
                        @continue
                    @endif
                    <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="department" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="sub_department_id" value="{{ __('แผนก') }}" />
            <select class="w-full mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    id="sub_department_id" wire:model="sub_department_id">
                    @foreach ($subDepartments as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                    @endforeach
            </select>
            <x-jet-input-error for="sub_department_id" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('สำเร็จ.') }}
        </x-jet-action-message>

        <button class="btn" type="submit">
            {{ __('บันทึก') }}
        </button>
    </x-slot>
</x-jet-form-section>
