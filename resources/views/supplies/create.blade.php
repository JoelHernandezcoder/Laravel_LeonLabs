<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create Supply
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <x-forms.form method="POST" action="/supplies">
                    <div class="space-y-6">
                        <x-forms.input label="Name" name="name" required />
                        <x-forms.input label="Stock" type="number" name="stock" required />
                        <x-forms.select label="Unit Code" name="unit_code" :options="['kg','lt','m']" require/>
                        <x-forms.input label="Price" type="number" name="price" required />
                        <x-forms.input label="Supplier" name="supplier" required />
                        <x-forms.input label="Expiration Date" name="expiration_date" type="date" required/>
                        <div class="text-center py-4">
                            <x-forms.button>Create Supply</x-forms.button>
                        </div>
                    </div>
                </x-forms.form>
                <div class="ml-4 mb-4">
                    <x-action-button href="/supplies">Supplier's List</x-action-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
