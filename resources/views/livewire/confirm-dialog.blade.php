<div>
    <x-jet-confirmation-modal wire:model="showingConfirmationDialog">
        <x-slot name="title">
            {{ $this->state['title'] ?? '' }}
        </x-slot>

        <x-slot name="content">
            {{ $this->state['message'] ?? '' }}
        </x-slot>

        <x-slot name="footer">
            <button class="btn btn-ghost" wire:click="$toggle('showingConfirmationDialog')"
                    wire:loading.attr="disabled">
                {{ __('app.cancel') }}
            </button>

            <button class="ml-2 btn btn-error" wire:click="$emitSelf('confirmed')"
                    wire:loading.attr="disabled">
                {{ __('app.confirm') }}
            </button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
