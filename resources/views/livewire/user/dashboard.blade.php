<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('หน้าหลัก') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="w-full text-right">
                <button class="btn btn-info" wire:click="$emit('user-transfer-create')">
                    {{ __('แจ้งย้าย') }}
                </button>
                <button class="btn btn-success ml-2" wire:click="$emit('user-claim-create')">
                    {{ __('แจ้งซ่อม') }}
                </button>
            </div>

            <div class="mt-3">
                <livewire:user.claim-table />
            </div>

            <div class="mt-3">
                <livewire:user.pre-claim-table />
            </div>

            <div class="mt-3">
                <livewire:user.transfer-table />
            </div>
        </div>
    </div>

    @push('modals')
        <livewire:user.claim-report />
    @endpush

    @push('modals')
        <livewire:user.transfer-report />
    @endpush
</div>
