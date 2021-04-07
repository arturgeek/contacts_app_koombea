<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Contacts') }}
        </h2>
    </x-slot>
    @if (count($files) === 0)
    <h2 class="py-3">You dont have contacts right now</h2>
    @else
    <table class="rounded-t-lg m-5 w-full mx-auto bg-gray-200 text-gray-800">
        <tr class="text-left border-b-2 border-gray-300">
            <th class="px-4 py-3">Name</th>
            <th class="px-4 py-3">Date Of Birth</th>
            <th class="px-4 py-3">Phone</th>
            <th class="px-4 py-3">Address</th>
            <th class="px-4 py-3">Email</th>
            <th class="px-4 py-3">Card Type</th>
            <th class="px-4 py-3">Last numbers</th>
        </tr>
        @foreach ($contacts as $contact)
        <tr cla1ss="bg-gray-100 border-b border-gray-200">
            <td class="px-4 py-3">{{ $contact->name }}</td>
            <td class="px-4 py-3">{{ $contact->date_of_birth }}</td>
            <td class="px-4 py-3">{{ $contact->phone }}</td>
            <td class="px-4 py-3">{{ $contact->address }}</td>
            <td class="px-4 py-3">{{ $contact->email }}</td>
            <td class="px-4 py-3">{{ $contact->cc_type }}</td>
            <td class="px-4 py-3">{{ $contact->cc_last }}</td>
        </tr> 
        @endforeach
    </table>
    @endif

</x-app-layout>