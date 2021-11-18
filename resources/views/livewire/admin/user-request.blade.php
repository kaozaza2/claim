<div>
    <div class="py-6">
        <div class="tabs max-w-7xl mx-auto lg:px-8">
            <a href="{{ route('admin.requests') }}" class="tab tab-bordered tab-active">
                {{ __('app.tab.requests') }}
            </a>
            <a href="{{ route('admin.claims') }}" class="tab tab-bordered">
                {{ __('app.tab.claims') }}
            </a>
            <a href="{{ route('admin.equipments') }}" class="tab tab-bordered">
                {{ __('app.tab.equipments') }}
            </a>
            <a href="{{ route('admin.departments') }}" class="tab tab-bordered">
                {{ __('app.tab.departments') }}
            </a>
            <a href="{{ route('admin.accounts') }}" class="tab tab-bordered">
                {{ __('app.tab.accounts') }}
            </a>
        </div>

        <div class="max-w-7xl sm:rounded-lg bg-white mt-6 mx-auto sm:px-6 lg:px-8">
            <livewire:admin.request.claim />
        </div>

        <div class="max-w-7xl sm:rounded-lg bg-white mt-6 mx-auto sm:px-6 lg:px-8">
            <livewire:admin.request.transfer />
        </div>
    </div>
</div>
