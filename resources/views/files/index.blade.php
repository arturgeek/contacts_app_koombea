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
    <h2 class="py-3">No files uploaded!</h2>
    @else
    <table class="rounded-t-lg m-5 w-full mx-auto bg-gray-200 text-gray-800">
        <tr class="text-left border-b-2 border-gray-300">
          <th class="px-4 py-3">Name</th>
          <th class="px-4 py-3">Creation Date</th>
          <th class="px-4 py-3">State</th>
          <th class="px-4 py-3">Errors</th>
        </tr>
        @foreach ($files as $file)
        <tr class="bg-gray-100 border-b border-gray-200">
            <td class="px-4 py-3">{{ $file->file_name }}</td>
            <td class="px-4 py-3">{{ date('Y m d', strtotime($file->created_at)) }}</td>
            <td class="px-4 py-3">{{ $file->state }}</td>
            <td class="px-4 py-3">
                @if( $file->errors != null && $file->errors != "" )
                    <button class="w-full p-1 bg-blue-500 hover:bg-blue-700 text-white show_file_errors" data-error-panel-id="error_panel_{{ $file->id }}">Show Errors</button>
                @endif
            </td>
        </tr> 
        <tr class="tr_errors hidden" id="error_panel_{{ $file->id }}">
            <td colspan="4" class="p-5">
                @if( $file->errors != null && $file->errors != "" )
                    <b class="block">Errors</b>
                    @foreach(json_decode($file->errors, JSON_UNESCAPED_UNICODE) as $error)
                    {{ $error }}
                    <br/>
                    @endforeach
                @endif
            </td>
        </tr>
        @endforeach
    </table>
    @endif

</x-app-layout>