<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{-- Forzamos el idioma tomando session('lang','en') como fallback --}}
            {{ __('messages.Dashboard', [], session('lang','en')) }}
        </h2>
    </x-slot>

    <div class="mx-2 my-2 p-4 flex flex-col lg:flex-row bg-white dark:bg-gray-800 rounded-md shadow-sm">
        <div class="p-4 text-gray-900 dark:text-gray-100 w-full h-full">
            <x-menu-button
                image="resources/images/client.png"
                link="/clients"
                text="{{ __('messages.CLIENTS', [], session('lang','en')) }}"
            />
            <x-menu-button
                image="resources/images/medication.png"
                link="/medications"
                text="{{ __('messages.MEDICATIONS', [], session('lang','en')) }}"
            />
            <x-menu-button
                image="resources/images/employee.png"
                link="/employees"
                text="{{ __('messages.EMPLOYEES', [], session('lang','en')) }}"
            />
            <x-menu-button
                image="resources/images/production.png"
                link="/production"
                text="{{ __('messages.PRODUCTION', [], session('lang','en')) }}"
            />
        </div>
        <div class="p-4 text-gray-900 dark:text-gray-100 w-full h-full">
            <x-menu-button
                image="resources/images/sale.png"
                link="/sales"
                text="{{ __('messages.SALES', [], session('lang','en')) }}"
            />
            <x-menu-button
                image="resources/images/supply.png"
                link="/supplies"
                text="{{ __('messages.SUPPLIES', [], session('lang','en')) }}"
            />
            <x-menu-button
                image="resources/images/service.png"
                link="/services"
                text="{{ __('messages.SERVICES', [], session('lang','en')) }}"
            />
            <x-menu-button
                image="resources/images/shipping.png"
                link="/shippings"
                text="{{ __('messages.SHIPPINGS', [], session('lang','en')) }}"
            />
        </div>
    </div>
</x-app-layout>
