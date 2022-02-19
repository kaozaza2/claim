<div>
    <div class="py-6">
        @livewire('admin-tab')

        <x-layout-box>
            <h1 class="text-2xl mb-2">{{ __('app.claim') }}</h1>

            @livewire('admin.request.claim')
        </x-layout-box>

        <x-layout-box>
            <h1 class="text-2xl mb-2">{{ __('app.transfer') }}</h1>

            @livewire('admin.request.transfer')
        </x-layout-box>
    </div>
</div>
