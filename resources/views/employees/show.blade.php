<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $employee->first_name }} {{ $employee->last_name }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                    {{ __('messages.Gender', [], session('lang','en')) }}: {{ $employee->gender }}
                </p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                    {{ __('messages.Address', [], session('lang','en')) }}: {{ $employee->address }}
                </p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                    {{ __('messages.Meal', [], session('lang','en')) }}: {{ $employee->meal_option }}
                </p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                    {{ __('messages.Role', [], session('lang','en')) }}: {{ $employee->role }}
                </p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                    {{ __('messages.Seniority', [], session('lang','en')) }}: {{ $employee->seniority }}
                </p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                    {{ __('messages.Salary', [], session('lang','en')) }}: ${{ $employee->salary }}
                </p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">
                    {{ __('messages.Start Date', [], session('lang','en')) }}: {{ $employee->start_date }}
                </p>

                <x-forms.divider/>

                <h1 class="dark:text-white mx-8 mt-4 font-bold text-xl">
                    {{ __('messages.Production Line', [], session('lang','en')) }}
                </h1>

                <ul class="p-8">
                    @if($line)
                        <x-action-button href="/lines/ {{ $line->id }}">
                            {{ $line->name }}
                        </x-action-button>
                    @else
                        <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">{{ __('messages.No production line assigned', [], session('lang', 'en')) }}</p>
                    @endif
                </ul>

                <x-forms.divider/>

                <div class="ml-4">
                    <x-action-button href="/employees">
                        {{ __("messages.Employees' List", [], session('lang','en')) }}
                    </x-action-button>
                </div>

                <x-forms.divider/>

                <form method="POST" action="{{ $employee->id }}">
                    @csrf
                    @method('DELETE')
                    <div class="text-end mx-4 mb-4">
                        <x-danger-button>
                            {{ __('messages.Delete Employee', [], session('lang','en')) }}
                        </x-danger-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
