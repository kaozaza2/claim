<div>
    <x-jet-confirmation-modal wire:model="showingWarningDialog">
        <x-slot name="title">
            {{ __('ข้อผิดพลาด') }}
        </x-slot>

        <x-slot name="content">
            {{ __('ยังไม่พร้อมใช้งานในขณะนี้') }}
        </x-slot>

        <x-slot name="footer">
            <button wire:click="$toggle('showingWarningDialog')" class="btn btn-ghost">
                {{ __('ปิด') }}
            </button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
