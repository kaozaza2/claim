<x-jet-confirmation-modal wire:model="showingErrorMessage">
    <x-slot name="title">
        {{ $message['title'] ?? __('ข้อผิดพลาด') }}
    </x-slot>

    <x-slot name="content">
        {{ $message['message'] ?? '' }}
    </x-slot>

    <x-slot name="footer">
        <button class="btn btn-ghost" wire:click="$toggle('showingErrorMessage')">
            {{ __('ปิด') }}
        </button>
    </x-slot>
</x-jet-confirmation-modal>
