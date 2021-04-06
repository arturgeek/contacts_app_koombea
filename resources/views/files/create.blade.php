<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New File') }}
        </h2>
    </x-slot>
    <form method="POST" action="/files">
        @csrf
        <div class="mb-4" id="file_panel">
            <h2>
                Select the Contacts file you want to commit.
            </h2>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="contacts_file">Contacts File</label>
            <input type="file" id="contacts_file" name="contacts_file" />
        </div>
        <div id="mapping_panel">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">File Name</label>
                <input disabled="disabled" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" class="form-control" name="name" id="name" />
            </div>
            <p>
                Please assign the headers of the file with the Customer Fields
            </p>
        </div>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 mt-2 px-4 roundedy" id="btn_upload_file">
            Upload File
        </button>
    </form>
</x-app-layout>