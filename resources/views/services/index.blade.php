<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Service
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <h1 class="dark:text-white mx-8 mt-4 font-bold text-xl">List</h1>
                <ul class="flex flex-col">
                    @foreach ($services ?? [] as $service)
                        <li class="group flex items-center dark:text-white/50 mx-8 mt-4">
                            <a href="/services/{{ $service->id }}" class="text-blue-800">
                                {{ $service->id }}). {{ $service->name }}
                            </a>
                            <span class="flex-1 border-b-2 border-dotted border-gray-400 mx-2"></span>
                            @if($service->paid)
                                <span class="bg-green-600 text-white text-sm px-2 py-1 rounded">Paid</span>
                            @elseif($service->expiration_date < now() )
                                <span class="bg-red-600 text-white text-sm px-2 py-1 rounded">Expired</span>
                            @else
                               <a href="/services/{{ $service->id }}" class="bg-yellow-500 text-white text-sm px-2 py-1 rounded">Payment</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <x-forms.divider/>
                <div class="mx-4">
                    {{ $services->links() }}
                </div>
                <div class="text-center mb-8">
                    <x-action-button href="/services/create" >Upload Invoice</x-action-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

