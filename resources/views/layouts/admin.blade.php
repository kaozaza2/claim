<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('หน้าควบคุม') }}
        </h2>
    </x-slot>

    {{ $slot }}

    @push('modals')
        <livewire:admin.accounts />
    @endpush
</x-app-layout>
