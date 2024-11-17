<!-- It is never too late to be what you might have been. - George Eliot -->
<div id="move-file-div" class="">
    <div id="child-move-file-div">
        <!-- Heading for Edit File -->
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-lg font-bold text-gray-700">Move File</h2> {{-- add summary --}}
            <button type="button" id="close-edit-btn"
                class="text-red-500 hover:text-red-700 focus:outline-none hover:cursor-pointer">
                <i class='bx bx-x bx-md'></i>
            </button>
        </div>

        <form>
            @csrf
            <div class="mx-20 grid gap-6 grid-cols-3 items-center">
                <!-- Origin Section -->
                <div>
                    <h1 class="text-center sm:text-left">Origin</h1>
                    <div class="grid grid-rows-2 gap-6">
                        <!-- Municipality Field -->
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="floating_first_name" id="floating_first_name"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />

                        </div>
                        <!-- Permit Type Field -->
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="text" name="floating_last_name" id="floating_last_name"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />

                        </div>
                    </div>
                </div>

                <!-- Center 'To' Text -->
                <div class="flex justify-center items-center">
                    <h1 class="text-lg font-semibold">To</h1>
                </div>

                <!-- Destination Section -->
                <div>
                    <h1 class="text-center sm:text-left">Destination</h1>
                    <div class="grid grid-rows-2 gap-6">
                        <!-- Municipality Field -->
                        <div class="relative z-0 w-full mb-5 group">
                            <select
                                class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                <option selected>Choose a country</option>
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="FR">France</option>
                                <option value="DE">Germany</option>
                            </select>

                        </div>

                        <!-- Permit Type Field -->
                        <div class="relative z-0 w-full mb-5 group">
                            <select
                                class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                                <option selected>Choose a country</option>
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="FR">France</option>
                                <option value="DE">Germany</option>
                            </select>

                        </div>
                    </div>
                </div>


            </div>
            <div class="w-full text-end">
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Save
                    changes</button>
            </div>
        </form>
    </div>
</div>
