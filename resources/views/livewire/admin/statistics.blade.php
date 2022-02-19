<div>
    <div class="py-6">
        @livewire('admin-tab')

        <x-layout-box :padding="false">
            <div class="w-full stats stats-vertical lg:stats-horizontal">
                @foreach ($stats as $stat)
                    <div class="stat">
                        <div class="stat-value">{{ $stat['count'] }}</div>
                        <div class="stat-title opacity-100">{{ $stat['name'] }}</div>
                        <div class="stat-desc opacity-100">{{ $stat['desc'] }}</div>
                    </div>
                @endforeach
            </div>
        </x-layout-box>

        <x-layout-box>
            <div class="tabs">
                <a class="tab tab-lifted tab-active">{{ __('app.reports.transfer') }}</a>
                <a class="tab tab-lifted">{{ __('app.reports.claim') }}</a>
                <a class="tab tab-lifted">{{ __('app.reports.claim-done') }}</a>
            </div>
            @livewire('admin.statistics.transfers')
        </x-layout-box>
    </div>
</div>
