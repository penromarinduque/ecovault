<!-- Sidebar -->

<aside
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0  "
    aria-label="Sidenav" id="drawer-navigation">
    <div class="overflow-y-auto py-5 px-3 h-full bg-[#363557]">

        <ul class="space-y-2">
            <!-- List Item -->
            <li
                class="flex items-center space-x-4 hover:bg-[#47476e] px-5 py-3 rounded-lg transition-colors duration-200">
                <a href="{{ route('admin.home.show') }}" class="flex items-center gap-4">
                    <img src="{{ asset('images/navigation/dashboard.png') }}" alt="Home" class="w-16">
                    <span class="text-lg font-semibold text-gray-200">Home</span>
                </a>
            </li>

            <li
                class="flex items-center space-x-4 hover:bg-[#47476e] px-5 py-3 rounded-lg transition-colors duration-200">
                <a href="{{ route('file-manager.show') }}" class="flex items-center gap-4">
                    <img src="{{ asset('images/navigation/file-manager.png') }}"
                        alt="Permits and Registration Documents" class="w-16">
                    <span class="text-lg font-semibold text-gray-200">Permits and Registration</span>
                </a>
            </li>

            <li
                class="flex items-center space-x-4 hover:bg-[#47476e] px-5 py-3 rounded-lg transition-colors duration-200">
                <a href="{{ route('administrative.show') }}" class="flex items-center gap-4">
                    <img src="{{ asset('images/navigation/reports.png') }}" alt="Administrative Documents"
                        class="w-16">
                    <span class="text-lg font-semibold text-gray-200">Administrative</span>
                </a>
            </li>

            <li
                class="flex items-center space-x-4 hover:bg-[#47476e] px-5 py-3 rounded-lg transition-colors duration-200">
                <a href="{{ route('archived-file.show') }}" class="flex items-center gap-4">
                    <img src="{{ asset('images/navigation/archive.png') }}" alt="Archived Files" class="w-16">
                    <span class="text-lg font-semibold text-gray-200">Archived</span>
                </a>
            </li>


        </ul>


    </div>

</aside>
