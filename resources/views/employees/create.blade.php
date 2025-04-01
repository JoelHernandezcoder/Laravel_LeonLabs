<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.Create Employee', [], session('lang','en')) }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <x-forms.form method="POST" action="/employees">
                    <div class="space-y-6">
                        <x-forms.input
                            label="{{ __('messages.First Name', [], session('lang','en')) }}"
                            name="first_name"
                            required
                        />
                        <x-forms.input
                            label="{{ __('messages.Last Name', [], session('lang','en')) }}"
                            name="last_name"
                            required
                        />

                        <x-forms.select
                            label="{{ __('messages.Gender', [], session('lang','en')) }}"
                            name="gender"
                            :options="[
                                'male' => __('messages.Male', [], session('lang','en')),
                                'female' => __('messages.Female', [], session('lang','en')),
                                'other' => __('messages.Other', [], session('lang','en')),
                            ]"
                            required
                        />

                        <x-forms.input
                            label="{{ __('messages.Address', [], session('lang','en')) }}"
                            name="address"
                            required
                        />

                        <x-forms.select
                            label="{{ __('messages.Meal Option', [], session('lang','en')) }}"
                            name="meal_option"
                            :options="[
                                'vegetarian' => __('messages.Vegetarian', [], session('lang','en')),
                                'classic' => __('messages.Classic', [], session('lang','en')),
                                'express' => __('messages.Express', [], session('lang','en')),
                            ]"
                            required
                        />

                        <x-forms.select
                            label="{{ __('messages.Role', [], session('lang','en')) }}"
                            name="role"
                            :options="[
                                'manager' => __('messages.Manager', [], session('lang','en')),
                                'supervisor' => __('messages.Supervisor', [], session('lang','en')),
                                'worker' => __('messages.Worker', [], session('lang','en')),
                            ]"
                            required
                        />

                        <x-forms.input
                            label="{{ __('messages.Seniority', [], session('lang','en')) }}"
                            name="seniority"
                            type="number"
                            required
                        />

                        <x-forms.input
                            label="{{ __('messages.Salary', [], session('lang','en')) }}"
                            name="salary"
                            type="number"
                            step="0.01"
                            required
                        />

                        <x-forms.input
                            label="{{ __('messages.Start Date', [], session('lang','en')) }}"
                            name="start_date"
                            type="date"
                            required
                        />

                        <div class="text-center py-4">
                            <x-forms.button>
                                {{ __('messages.Create Employee', [], session('lang','en')) }}
                            </x-forms.button>
                        </div>
                    </div>
                </x-forms.form>

                <div class="ml-4 mt-4">
                    <x-action-button href="/employees">
                        {{ __("messages.Employees' List", [], session('lang','en')) }}
                    </x-action-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
