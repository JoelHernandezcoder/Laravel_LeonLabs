<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create Employee
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <x-forms.form method="POST" action="/employees">
                    <div class="space-y-6">
                        <x-forms.input label="First Name" name="first_name" required />
                        <x-forms.input label="Last Name" name="last_name" required />

                        <x-forms.select label="Gender" name="gender" :options="['male' => 'Male', 'female' => 'Female', 'other' => 'Other']" required />

                        <x-forms.input label="Address" name="address" required />

                        <x-forms.select label="Meal Option" name="meal_option" :options="['vegetarian' => 'Vegetarian', 'classic' => 'Classic', 'express' => 'Express']" required />

                        <x-forms.select label="Role" name="role" :options="['manager' => 'Manager', 'supervisor' => 'Supervisor', 'worker' => 'Worker']" required />

                        <x-forms.input label="Seniority" name="seniority" type="number" required />

                        <x-forms.input label="Salary" name="salary" type="number" step="0.01" required />

                        <x-forms.input label="Start Date" name="start_date" type="date" required />

                        <div class="text-center py-4">
                            <x-forms.button>Create Employee</x-forms.button>
                        </div>
                    </div>
                </x-forms.form>
                <div class="ml-4 mt-4">
                    <x-action-button href="/employees">Employees' List</x-action-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
