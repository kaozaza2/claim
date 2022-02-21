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

        <x-layout-box x-data="{ active: 1 }">
            <div class="tabs">
                <a :class="{ 'tab-active': active === 1 }" @click="active=1" class="tab tab-lifted">
                    {{ __('app.reports.transfer') }}
                </a>
                <a :class="{ 'tab-active': active === 2 }" @click="active=2" class="tab tab-lifted">
                    {{ __('app.reports.claim') }}
                </a>
            </div>

            <div :class="{'hidden': active !== 1}">
                @livewire('admin.statistics.transfers')
            </div>

            <div :class="{'hidden': active !== 2}" class="hidden">
                @livewire('admin.statistics.claims')
            </div>
        </x-layout-box>
    </div>
</div>
