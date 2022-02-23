<nav class="w-full bg-white border-b shadow-lg">
    <div class="navbar bg-white mx-auto max-w-7xl">
        <div class="flex-none">
            <a href="{{ route('dashboard') }}" class="btn btn-ghost px-0">
                <x-jet-application-logo/>
                <span class="hidden lg:inline-block pr-2 text-3xl font-bold">{{ config('app.name', 'Laravel') }}</span>
            </a>
        </div>
        <div class="flex-none px-2 ml-auto mr-0 flex">
            <div class="items-stretch flex">

                <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm rounded-btn">
                    {{ __('app.nav.dashboard') }}
                </a>

                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin') }}" class="btn btn-ghost btn-sm rounded-btn">
                        {{ __('app.nav.control') }}
                    </a>

                    <a href="{{ route('admin.statistics') }}" class="btn btn-ghost btn-sm rounded-btn">
                        {{ __('app.tab.statistics') }}
                    </a>
                @endif

                <div class="dropdown dropdown-end">
                    <div tabindex="0" class="btn btn-ghost btn-sm rounded-btn">
                        {{ __('app.nav.profile') }}
                    </div>
                    <div tabindex="0" class="card compact border shadow dropdown-content bg-base-100 rounded w-56">
                        <div class="card-body p-3">
                            <p class="card-title text-base">{{ auth()->user()->fullname }}</p>
                            <p>{{ auth()->user()->email }}</p>
                            <hr class="my-2"/>
                            <div>
                                <a href="{{ route('profile.show') }}" class="w-full text-left btn btn-sm btn-ghost">
                                    {{ __('app.profile') }}
                                </a>
                                <form method="post" action="{{ route('logout') }}">
                                    @csrf

                                    <a href="{{ route('logout') }}" class="w-full text-left btn btn-sm btn-ghost"
                                       onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('app.logout') }}
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
