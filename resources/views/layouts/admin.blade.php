<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('หน้าควบคุม') }}
        </h2>
    </x-slot>

    {{ $slot }}
</x-app-layout>
