<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Employees
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <h1 class="dark:text-white mx-8 mt-4 font-bold text-xl">List</h1>
                <ul class="flex flex-col">
                    @foreach ($employees ?? [] as $employee)
                        <a href="/employees/{{$employee->id}}" class="dark:text-white/50 mx-8 mt-4 text-blue-800">{{$employee->id}}). {{ $employee->first_name }} {{ $employee->last_name }}</a>
                    @endforeach
                </ul>
                <x-forms.divider/>
                <div class="mx-4">
                    {{ $employees->links() }}
                </div>
                <div class="text-center mb-8">
                    <x-action-button href="/employees/create" >Create Employee</x-action-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

