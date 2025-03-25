<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Supplies
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <h1 class="dark:text-white mx-8 mt-4 font-bold text-xl">List</h1>
                <ul class="flex flex-col">
                    @foreach ($supplies ?? [] as $supply)
                        <li class="group flex items-center dark:text-white/50 mx-8 mt-4">
                            <a href="/supplies/{{$supply->id}}" class="text-blue-800">{{ $supply->id }}). {{ $supply->name }}</a>
                            <span class="flex-1 border-b-2 border-dotted border-gray-400 mx-2"></span>
                            @if($supply->expiration_date < now() )
                                <x-danger-span>Expired</x-danger-span>
                            @else
                                <x-success-span>Correct</x-success-span>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <x-forms.divider/>
                <div class="mx-4">
                    {{ $supplies->links() }}
                </div>
                <div class="text-center mb-8">
                    <x-action-button href="/supplies/create" >Create Supply</x-action-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

