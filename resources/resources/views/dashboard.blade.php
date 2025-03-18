<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
        <div class="mx-2 my-2 p-4 flex flex-col lg:flex-row bg-white dark:bg-gray-800 rounded-md shadow-sm">
            <div class="p-4 text-gray-900 dark:text-gray-100 w-full h-full">
                <x-menu-button image="resources/images/client.png" link="/clients" text="CLIENTS" />
                <x-menu-button image="resources/images/medication.png" link="/medications" text="MEDICATIONS" />
                <x-menu-button image="resources/images/employee.png" link="/employees" text="EMPLOYEES" />
                <x-menu-button image="resources/images/production.png" link="/production" text="PRODUCTION" />
            </div>
            <div class="p-4 text-gray-900 dark:text-gray-100 w-full h-full">
                <x-menu-button image="resources/images/sale.png" link="/sales" text="SALES" />
                <x-menu-button image="resources/images/supply.png" link="/supplies" text="SUPPLIES" />
                <x-menu-button image="resources/images/service.png" link="/services" text="SERVICES" />
                <x-menu-button image="resources/images/shipping.png" link="/shippings" text="SHIPPINGS" />
            </div>
        </div>
</x-app-layout>
