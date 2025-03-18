<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $employee->first_name }} {{ $employee->last_name }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Gender: {{$employee->gender}}</p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Address: {{$employee->address}}</p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Meal: {{$employee->meal_option}}</p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Role: {{$employee->role}}</p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Seniority: {{$employee->seniority}}</p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Salary: ${{$employee->salary}}</p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Start Date: {{$employee->start_date}}</p>

                <h1 class="dark:text-white mx-8 mt-4 font-bold text-xl">Production Line</h1>
                <ul>
                        <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">{{ $employee->line}}</p>
                </ul>

                <x-forms.divider/>

                <div class="ml-4">
                    <x-action-button href="/employees">Employees's List</x-action-button>
                </div>

                <x-forms.divider/>

                <form method="POST" action="{{$employee->id}}">
                    @csrf
                    @method('DELETE')
                    <div class="text-end mx-4 mb-4">
                        <x-danger-button>Delete Employee</x-danger-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
