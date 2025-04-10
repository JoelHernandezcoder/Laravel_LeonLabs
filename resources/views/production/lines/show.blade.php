<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.Line', [], session('lang','en')) }} {{ $line->id }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ url("/lines/{$line->id}/employees") }}">
                @csrf
                    <div class="flex items-center space-x-4 mb-6">
                        <select name="employee" class="rounded-md p-2 w-full max-w-sm" required>
                            <option value="">{{ __("messages.Employees' List", [], session('lang','en')) }}</option>
                            @foreach ($allEmployees as $employee)
                                <option value="{{ $employee->id }}">
                                    {{ $employee->first_name }} {{ $employee->last_name }}
                                </option>
                            @endforeach
                        </select>


                        <x-forms.button>{{ __('messages.Add Employee', [], session('lang','en')) }}</x-forms.button>
                    </div>
                </form>

                {{-- Tabla de empleados asignados --}}
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="border-b">
                        <th class="p-2 dark:text-white">{{ __('messages.ID', [], session('lang','en')) }}</th>
                        <th class="p-2 dark:text-white">{{ __('messages.Full Name', [], session('lang','en')) }}</th>
                        <th class="p-2 dark:text-white">{{ __('messages.Salary U$D', [], session('lang','en')) }}</th>
                        <th class="p-2"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($employees ?? [] as $employee)
                        <tr class="border-b">
                            <td class="p-2">
                                <a href="/employees/{{ $employee->id }}" class="text-blue-800">
                                    {{ $employee->id }}
                                </a>
                            </td>
                            <td class="p-2 dark:text-white">
                                {{ $employee->first_name }} {{ $employee->last_name }}
                            </td>
                            <td class="p-2 dark:text-white">
                                {{ $employee->salary }}
                            </td>
                            <td class="p-2 text-right">
                                <form method="POST" action="{{ url("/lines/{$line->id}/employees/{$employee->id}") }}">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="font-bold bg-red-600 hover:bg-red-700 text-white px-2 rounded-full text-xl"
                                    >
                                        X
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <x-forms.divider/>

                <div class="p-4">
                    <x-action-button href="/lines">
                        {{ __('messages.Production Lines', [], session('lang','en')) }}
                    </x-action-button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
