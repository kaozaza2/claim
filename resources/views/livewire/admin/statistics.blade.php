<div>
    <div class="py-6">
        @livewire('admin-tab')

        <x-layout-box :padding="false">
            <div class="w-full stats stats-vertical lg:stats-horizontal">
                @foreach ($stats as $stat)
                    <div class="stat">
                        @if (Arr::has($stat, 'download'))
                            <div class="stat-figure">
                                <button class="btn btn-success" wire:click="$emit('{{ $stat['download']['link'] }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 0 24 24" width="18px"
                                         fill="currentColor">
                                        <path d="M0 0h24v24H0V0z" fill="none"/>
                                        <path
                                            d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2v9.67z"/>
                                    </svg>
                                </button>
                            </div>
                        @endif
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

@push('modals')
    @livewire('admin.statistics.equipments')
@endpush

@push('modals')
    @livewire('admin.statistics.in-claims')
@endpush
