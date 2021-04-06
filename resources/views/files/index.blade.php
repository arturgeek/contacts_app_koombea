<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Files') }}
        </h2>
    </x-slot>
    
    <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="files/create">
        Add New Contacts File
    </a>
    <br/>
    @if (count($files) === 0)
    <h2>No files uploaded!</h2>
    @else
    <table class="rounded-t-lg m-5 w-full mx-auto bg-gray-200 text-gray-800">
        <tr class="text-left border-b-2 border-gray-300">
          <th class="px-4 py-3">Name</th>
          <th class="px-4 py-3">State</th>
          <th class="px-4 py-3">Creation Date</th>
        </tr>
        
        <tr class="bg-gray-100 border-b border-gray-200">
            @foreach ($files as $file)
                <td class="px-4 py-3">{{ $file->file_name }}</td>
                <td class="px-4 py-3">{{ date('Y m d', strtotime($file->created_at)) }}</td>
                <td class="px-4 py-3">{{ $file->state }}</td>
            @endforeach
        </tr> 
    </table>
    @endif

</x-app-layout>