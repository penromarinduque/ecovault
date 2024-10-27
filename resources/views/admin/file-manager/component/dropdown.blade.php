<button id="dropdownLeftButton${file.id}"
    class="inline-flex items-center p-0.5 text-sm font-medium text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none"
    type="button">
    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
    </svg>
</button>
<div id="dropdownLeft${file.id}" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow-lg">
    <ul class="py-2 text-sm text-gray-700 border border-gray-200 divide-y divide-gray-400">
        <a class="block px-4 py-2 cursor-pointer hover:bg-gray-100" onclick="openFileModal(${file.id})">View</a>
        <li><a href="/api/files/download/${file.id}" class="block px-4 py-2 hover:bg-gray-100">Download</a></li>
        <li><button class="edit-button block px-4 py-2 hover:bg-gray-100" data-file-id="${file.id}">Edit</button></li>
        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Move</a></li>
        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Share</a></li>
        <li><button class="file-summary-button block px-4 py-2 hover:bg-gray-100" data-file-id="${file.id}">File
                Summary</button></li>
        <li><button onclick="archiveFile(${file.id})" class="block px-4 py-2 hover:bg-gray-100">Archived</button></li>
    </ul>
</div>
