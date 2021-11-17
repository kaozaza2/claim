<x-jet-confirmation-modal wire:model="showingErrorMessage">
    <x-slot name="title">
        {{ $message['title'] ?? __('app.modal.title-error') }}
    </x-slot>

    <x-slot name="content">
        <p class="px-1 py-3">{{ $message['message'] ?? '' }}</p>
    </x-slot>

    <x-slot name="footer">
        <button class="btn btn-ghost" wire:click="$toggle('showingErrorMessage')">
            {{ __('app.close') }}
        </button>
    </x-slot>
</x-jet-confirmation-modal>
