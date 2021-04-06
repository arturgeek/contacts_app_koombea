<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <ul>
        <li class="py-3"><a href="/files">Files</a></li>
        <li class="py-3"><a href="/contacts">Contacts</a></li>
    </ul>
</x-app-layout>