<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.Create Client', [], session('lang','en')) }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <x-forms.form method="POST" action="/clients">
                    <div class="space-y-20">
                        <x-forms.input
                            label="{{ __('messages.Name', [], session('lang','en')) }}"
                            name="name"
                            required
                        />
                        <x-forms.input
                            label="{{ __('messages.Country', [], session('lang','en')) }}"
                            name="country"
                            required
                        />
                        <div class="text-center">
                            <x-forms.button>
                                {{ __('messages.Create Client', [], session('lang','en')) }}
                            </x-forms.button>
                        </div>
                    </div>
                </x-forms.form>

                <div class="ml-4 mb-4">
                    <x-action-button href="/clients">
                        {{ __("messages.Client's List", [], session('lang','en')) }}
                    </x-action-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
