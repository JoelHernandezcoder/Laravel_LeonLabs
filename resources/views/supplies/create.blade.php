<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create Medication
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <x-forms.form method="POST" action="/medications">
                    <div class="space-y-6">
                        <x-forms.input label="Name" name="name" required />
                        <x-forms.input label="Price" name="price" required />
                        <x-forms.input label="Description" name="description" required />
                        <x-forms.input label="Photo Url" name="photo" required />
                        <div class="text-center py-4">
                            <x-forms.button>Create Medication</x-forms.button>
                        </div>
                    </div>
                </x-forms.form>
                <div class="ml-4 mb-4">
                    <x-action-button href="/medications">Medication's List</x-action-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
