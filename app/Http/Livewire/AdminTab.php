<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;

class AdminTab extends Component
{
    public array $menus;

    public function mount(Request $request)
    {
        $this->menus = [
            ['route' => route('admin.requests'), 'name' => __('app.tab.requests'), 'active' => $request->routeIs('admin.requests')],
            ['route' => route('admin.claims'), 'name' => __('app.tab.claims'), 'active' => $request->routeIs('admin.claims')],
            ['route' => route('admin.equipments'), 'name' => __('app.tab.equipments'), 'active' => $request->routeIs('admin.equipments')],
            ['route' => route('admin.departments'), 'name' => __('app.tab.departments'), 'active' => $request->routeIs('admin.departments')],
            ['route' => route('admin.statistics'), 'name' => __('app.tab.statistics'), 'active' => $request->routeIs('admin.statistics')],
            ['route' => route('admin.accounts'), 'name' => __('app.tab.accounts'), 'active' => $request->routeIs('admin.accounts')],
            ['route' => route('admin.archives'), 'name' => __('app.tab.archives'), 'active' => $request->routeIs('admin.archives')],
        ];
    }

    public function render()
    {
        return view('livewire.admin-tab');
    }
}
