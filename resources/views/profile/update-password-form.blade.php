<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('เปลี่ยนรหัสผ่าน') }}
    </x-slot>

    <x-slot name="description">
        {{ __('เพื่อให้มั่นใจว่าบัญชีของคุณจะไม่ถูกบุกรุกจากบุคคลที่ 3 แนะนำให้ตั้งไม่ซ้ำและไม่ง่ายเกินไป') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="current_password" value="{{ __('รหัสผ่านปัจจุบัน') }}" />
            <input id="current_password" type="password" class="input input-bordered mt-1 block w-full" wire:model.defer="state.current_password" autocomplete="current-password">
            <x-jet-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password" value="{{ __('รหัสผ่านใหม่') }}" />
            <input id="password" type="password" class="input input-bordered mt-1 block w-full" wire:model.defer="state.password" autocomplete="new-password">
            <x-jet-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="password_confirmation" value="{{ __('ยืนยันรหัสผ่าน') }}" />
            <input id="password_confirmation" type="password" class="input input-bordered mt-1 block w-full" wire:model.defer="state.password_confirmation" autocomplete="new-password">
            <x-jet-input-error for="password_confirmation" class="mt-2" />
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
