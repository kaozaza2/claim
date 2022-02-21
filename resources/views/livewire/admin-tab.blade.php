<div class="tabs max-w-7xl mx-auto lg:px-8">
    @foreach($menus as $menu)
        <a href="{{ $menu['route'] }}" @class(['tab', 'tab-bordered', 'tab-active' => $menu['active']])>
            {{ $menu['name'] }}
        </a>
    @endforeach
</div>
