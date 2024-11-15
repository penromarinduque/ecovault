<aside class="w-64 bg-[#363557] h-full  fixed top-20  py-4">

    <div class="flex justify-center  mt-8 ">
        <button class="bg-white px-4 py-2 rounded-md">Hide Menu</button>
    </div>

    <ul class="mx-4 flex flex-col space-y-8 mt-8 text-white">
        <li class="flex items-center space-x-4 hover:bg-[#47476e] px-5 py-3 rounded-lg transition-colors duration-200">
            <a href="{{ route('admin.home.show') }}" class="flex items-center gap-4">
                <img src="{{ asset('images/navigation/dashboard.png') }}" alt="" class="w-16">
                <img src="{{ asset('images/navigation/dashboard.png') }}" alt="Home" class="w-12">
                <span class="text-lg font-semibold text-gray-200">Home</span>
            </a>
        </li>

        <li class="flex items-center space-x-2">
            <a href="{{ route('file-manager.show') }}" class="flex  gap-2 items-center">
                <img src="{{ asset('images/navigation/file-manager.png') }}" alt="" class="w-16">
                <span class="">File Manager</span>
            </a>
        </li>

        <li class="flex items-center space-x-2">
            <a href="#" class="flex  gap-2 items-center">
                <img src="{{ asset('images/navigation/reports.png') }}" alt="" class="w-16">
                <span class="">Adminstrive Documents</span>
            </a>
        </li>

        <li class="flex items-center space-x-2">
            <a href="#" class="flex  gap-2 items-center">
                <img src="{{ asset('images/navigation/archive.png') }}" alt="" class="w-16">
                <span class="">Archive Files</span>
            </a>
        </li>

        <li class="flex items-center space-x-2">
            <a href="#" class="flex  gap-2 items-center">
                <img src="{{ asset('images/navigation/backup-and-recovery.png') }}" alt="" class="w-16">
                <span class="w-8/12">Back up and Recovery</span>
            </a>
        </li>
    </ul>



</aside>
