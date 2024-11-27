<!-- The whole future lies in uncertainty: live immediately. - Seneca -->



<div class="folder-container flex gap-4 mb-4">
    <!--populate the folder-->
</div>


<template class="folder-template">
    <div class="folder-content w-full max-w-xs bg-white border border-gray-300 rounded-md">
        <div class="flex items-center justify-between px-4 py-3">
            <!-- Content Section -->
            <div class="flex items-center space-x-3">
                <!-- Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                    class="w-10 h-10 text-slate-600">
                    <path
                        d="M19.5 21a3 3 0 0 0 3-3v-4.5a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3V18a3 3 0 0 0 3 3h15ZM1.5 10.146V6a3 3 0 0 1 3-3h5.379a2.25 2.25 0 0 1 1.59.659l2.122 2.121c.14.141.331.22.53.22H19.5a3 3 0 0 1 3 3v1.146A4.483 4.483 0 0 0 19.5 9h-15a4.483 4.483 0 0 0-3 1.146Z" />
                </svg>

                <!-- Text Content -->
                <div class="flex flex-col">
                    <h5 class="folder-title text-sm font-medium text-gray-900">Folder Title</h5>
                    <span class="folder-text text-xs text-gray-500">Folder Description</span>
                </div>
            </div>

            <!-- Dropdown Button -->
            <div class="relative">
                <button data-dropdown-toggle="folder-dropdown"
                    class="folder-dropdown-btn inline-block text-gray-500 hover:bg-gray-100 focus:ring-2 focus:outline-none focus:ring-gray-200 rounded-md text-xs p-1"
                    type="button">
                    <span class="sr-only">Open dropdown</span>
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 4 15">
                        <path
                            d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div
                    class="folder-dropdown z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-md shadow w-36">
                    <ul class="py-1" aria-labelledby="folder-modal-toggle">
                        <li>
                            <a href="#" class="block px-3 py-1 text-xs text-gray-700 hover:bg-gray-100">Edit</a>
                        </li>
                        <li>
                            <a href="#" class="block px-3 py-1 text-xs text-gray-700 hover:bg-gray-100">Export
                                Data</a>
                        </li>
                        <li>
                            <a href="#" class="block px-3 py-1 text-xs text-red-600 hover:bg-gray-100">Delete</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>





<script>
    let cardCoundter = 0;

    function createFolderCard(title, content) {
        const template = document.querySelector('.folder-template');
        const cardClone = template.content.cloneNode(true);

        //set the content for the folder
        cardClone.querySelector('.folder-title').textContent = title;
        cardClone.querySelector('.folder-text').textContent = content;

        //get the dropdown
        const dropdownId = `folder-dropdown-${++cardCoundter}`;
        const dropdown = cardClone.querySelector('.folder-dropdown');
        const dropDownToggle = cardClone.querySelector('.folder-dropdown-btn');

        //set the id of dropdown
        dropdown.id = dropdownId;
        dropDownToggle.setAttribute('data-dropdown-toggle', `${dropdownId}`);

        document.querySelector('.folder-container').appendChild(cardClone);
    }

    createFolderCard('bots', 'test');
    createFolderCard('ai', 'boost');
    createFolderCard('bots', 'test');
    createFolderCard('ai', 'boost');
    createFolderCard('bots', 'test');
</script>
