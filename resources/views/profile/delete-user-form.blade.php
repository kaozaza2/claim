<x-jet-action-section>
    <x-slot name="title">
        {{ __('ลบบัญชี') }}
    </x-slot>

    <x-slot name="description">
        {{ __('ลบบัญชีอย่างถาวร.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('เมื่อบัญชีของคุณถูกลบ ข้อมูลทั้งหมดจะถูกลบให้หายไป, ก่อนที่จะลบบัญชีแนะนำให้สำรองข้อมูลที่จำเป็นเอาไว้.') }}
        </div>

        <div class="mt-5">
            <button class="btn btn-error" wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                {{ __('ลบบัญชี') }}
            </button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingUserDeletion">
            <x-slot name="title">
                {{ __('ลบบัญชี') }}
            </x-slot>

            <x-slot name="content">
                {{ __('คุณมั่นใจหรือไม่ ? เมื่อบัญชีของคุณถูกลบข้อมูลทั้งหมดจะถูกลบให้หายไปไม่สามารถกู้คืนได้อีก.') }}

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <input type="password" class="input input-bordered w-3/4 mt-1 block"
                                placeholder="{{ __('รหัสผ่าน') }}"
                                x-ref="password"
                                wire:model.defer="password"
                                wire:keydown.enter="deleteUser" />

                    <x-jet-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-ghost" wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    {{ __('ยกเลิก') }}
                </button>

                <button class="ml-2 btn btn-error" wire:click="deleteUser" wire:loading.attr="disabled">
                    {{ __('ลบบัญชี') }}
                </button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-jet-action-section>
