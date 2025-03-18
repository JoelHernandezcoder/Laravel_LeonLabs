<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $service->name }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Price per Month: {{$service->price}}</p>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">Expiration Date: {{$service->expiration_date}}</p>

                <x-forms.divider/>

                <h1 class="dark:text-white mx-8 mt-4 font-bold text-xl">Service batch</h1>
                <p class="dark:text-white text-lg mx-8 mt-4 text-blue-800">{{$batch}}</p>

                <x-forms.divider/>

                @if(!$service->paid)
                    <x-forms.form method="POST" action="/services/{{ $service->id }}/pay">
                        @csrf
                        <div class="text-center py-4">
                            <x-forms.button>Pay</x-forms.button>
                        </div>
                    </x-forms.form>
                @endif

                <x-forms.divider/>

                <div class="ml-4">
                    <x-action-button href="/services">Services's List</x-action-button>
                </div>

                <x-forms.divider/>

                <form method="POST" action="{{$service->id}}">
                    @csrf
                    @method('DELETE')
                    <div class="text-end mx-4 mb-4">
                        <x-danger-button>Delete Service</x-danger-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
