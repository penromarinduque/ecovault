<div>
    <!-- Modal for displaying files -->
    <div id="fileModal" class="fixed inset-0 bg-black bg-opacity-85 flex items-center justify-center z-50 hidden">
        <!-- Close Button -->
        <div class="absolute top-4 left-4">
            <div class="flex  gap-4 items-center justify-between w-full">
                <button
                    class="text-white text-2xl cursor-pointer hover:bg-gray-50/50 rounded-full w-12 h-12 flex items-center justify-center"
                    onclick="closeFileModal()">
                    &times;
                </button>
                <h1 id="file-name" class="text-white text-xl text-center flex-grow"></h1>
            </div>
        </div>


        <div class="relative w-full h-[700px] mt-28">
            <iframe id="fileFrame"
                class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8/12 h-full border-none"></iframe>
        </div>


    </div>

</div>
