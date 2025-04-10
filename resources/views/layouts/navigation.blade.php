<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">

    <!-- Primary Navigation Menu -->
    <div class="px-4 sm:px-6 lg:px-8 flex justify-between h-16">
        <div class="flex items-center">
            <!-- Logo + Texto con sombras según tema -->
            <div class="shrink-0 flex items-center transition-all duration-300
                drop-shadow-[0_2px_6px_rgba(0,0,0,0.2)] hover:drop-shadow-[0_4px_12px_rgba(0,0,0,0.3)]
                dark:drop-shadow-[0_0_10px_rgba(34,211,238,0.4)] dark:hover:drop-shadow-[0_0_16px_rgba(34,211,238,0.6)]">

                <a class="flex items-center justify-center" href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    <h1 class="p-4 text-xl font-bold bg-gradient-to-r from-blue-500 to-rose-500 bg-clip-text text-transparent" style="font-family: 'Press Start 2P', cursive;">
                        LEON'S LAB
                    </h1>
                </a>
            </div>
        </div>

        <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">

                <!-- Languages -->
            <!-- Languages -->
            <div class="flex items-center space-x-1">
                <x-dropdown-link :href="route('change.language', 'es')"
                                 class="{{ session('lang','en') === 'es' ? '' : 'opacity-50' }}">
                    <img
                        src="{{ Vite::asset('resources/images/flags/argentina-flag.png') }}"
                        alt="Español"
                        class="inline-block w-6 h-6 transition-all duration-300
                   drop-shadow-[0_2px_6px_rgba(0,0,0,0.2)] hover:drop-shadow-[0_4px_12px_rgba(0,0,0,0.3)]
                   dark:drop-shadow-[0_0_10px_rgba(34,211,238,0.4)] dark:hover:drop-shadow-[0_0_16px_rgba(34,211,238,0.6)]"
                    />
                </x-dropdown-link>

                <x-dropdown-link :href="route('change.language', 'en')"
                                 class="{{ session('lang','en') === 'en' ? '' : 'opacity-50' }}">
                    <img
                        src="{{ Vite::asset('resources/images/flags/us-flag.png') }}"
                        alt="English"
                        class="inline-block w-6 h-6 transition-all duration-300
                   drop-shadow-[0_2px_6px_rgba(0,0,0,0.2)] hover:drop-shadow-[0_4px_12px_rgba(0,0,0,0.3)]
                   dark:drop-shadow-[0_0_10px_rgba(34,211,238,0.4)] dark:hover:drop-shadow-[0_0_16px_rgba(34,211,238,0.6)]"
                    />
                </x-dropdown-link>
            </div>


            <!-- Settings Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium
                                   rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800
                                   hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                        >
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('messages.Profile', [], session('lang','en')) }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('messages.Log Out', [], session('lang','en')) }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Responsive) -->
            <div class="-me-2 flex items-center sm:hidden">
                <!-- Languages -->
                <div class="flex items-center space-x-1">
                    <x-dropdown-link :href="route('change.language', 'es')"
                                     class="{{ session('lang','en') === 'es' ? '' : 'opacity-50' }}"
                    >
                        <img
                            src="{{ Vite::asset('resources/images/flags/argentina-flag.png') }}"
                            alt="Español"
                            class="inline-block w-6 h-6"
                        />
                    </x-dropdown-link>
                    <x-dropdown-link :href="route('change.language', 'en')"
                                     class="{{ session('lang','en') === 'en' ? '' : 'opacity-50' }}"
                    >
                        <img
                            src="{{ Vite::asset('resources/images/flags/us-flag.png') }}"
                            alt="English"
                            class="inline-block w-6 h-6"
                        />
                    </x-dropdown-link>
                </div>
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500
                               hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900
                               focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500
                               dark:focus:text-gray-400 transition duration-150 ease-in-out"
                >
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <!-- Icono hamburguesa -->
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"
                        />
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                    {{ Auth::user()->name }}
                </div>
                <div class="font-medium text-sm text-gray-500">
                    {{ Auth::user()->email }}
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                                     onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('messages.Log Out', [], session('lang','en')) }}
                    </x-dropdown-link>
                </form>
            </div>

        </div>
    </div>
</nav>
