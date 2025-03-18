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
                        <x-forms.select label="Batch" name="production_order_id" :options="$orders" required />
                        <x-forms.input label="Sevice" name="name" required />
                        <x-forms.input label="Price" name="price" type="number" required />
                        <x-forms.input label="Expiration Date" name="expiration_date" type="date" required />
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
