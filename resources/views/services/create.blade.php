<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Upload Invoice
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <x-forms.form method="POST" action="/services">
                    <div class="space-y-6">
                        <x-forms.select label="{{ __('messages.Batch', [], session('lang','en')) }}" name="production_order_id" :options="$orders" required />
                        <x-forms.select label="{{ __('messages.Services', [], session('lang','en')) }}" name="name" :options="[
                            __('messages.Light', [], session('lang', 'en')),
                            __('messages.Gas', [], session('lang', 'en')),
                            __('messages.Internet', [], session('lang', 'en')),
                            __('messages.Cleaning Service', [], session('lang', 'en')),
                            __('messages.Maintenance', [], session('lang', 'en')),
                            __('messages.Water Supply', [], session('lang', 'en')),
                            __('messages.Quality Control', [], session('lang', 'en')),
                            __('messages.Waste Management', [], session('lang', 'en')),
                            __('messages.Laboratory Services', [], session('lang', 'en')),
                            __('messages.Sterilization', [], session('lang', 'en')),
                            __('messages.Raw Material Supply', [], session('lang', 'en')),
                            __('messages.Security', [], session('lang', 'en'))
                        ]" required />
                        <x-forms.input label="{{ __('messages.Price U$D', [], session('lang','en')) }}" name="price" type="number" required />
                        <x-forms.input label="{{ __('messages.Expiration Date', [], session('lang','en')) }}" name="expiration_date" type="date" required />
                        <div class="text-center py-4">
                            <x-forms.button>Upload Invoice</x-forms.button>
                        </div>
                    </div>
                </x-forms.form>
                <div class="ml-4 mb-4">
                    <x-action-button href="/services">Services's List</x-action-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
