<!-- Sidebar -->

<aside
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0  "
    aria-label="Sidenav" id="drawer-navigation">
    <div class="overflow-y-auto py-5 px-3 h-full bg-[#363557]">

        <ul class="space-y-2">
            <!-- List Item -->
            <li
                class="flex items-center space-x-4 hover:bg-[#47476e] px-5 py-3 rounded-lg transition-colors duration-200">
                <a href="{{ route('admin.home.show') }}" class="flex items-center gap-4 w-full">
                    <img src="{{ asset('images/navigation/dashboard.png') }}" alt="Home" class="w-12">
                    <span class="text-lg font-semibold text-gray-200">Dashboard</span>
                </a>
            </li>

            <li
                class="flex items-center space-x-4 hover:bg-[#47476e] px-5 py-3 rounded-lg transition-colors duration-200">
                <a href="{{ route('file-manager.show') }}" class="flex items-center gap-4 w-full">
                    <img src="{{ asset('images/navigation/file-manager.png') }}"
                        alt="Permits and Registration Documents" class="w-12">
                    <span class="text-lg font-semibold text-gray-200">Permits and Registration</span>
                </a>
            </li>

            <li
                class="flex items-center space-x-4 hover:bg-[#47476e] px-5 py-3 rounded-lg transition-colors duration-200">
                <a href="{{ route('administrative.show') }}" class="flex items-center gap-4 w-full">
                    <img src="{{ asset('images/navigation/reports.png') }}" alt="Administrative Documents"
                        class="w-12">
                    <span class="text-lg font-semibold text-gray-200">Administrative</span>
                </a>
            </li>

            <li
                class="flex items-center space-x-4 hover:bg-[#47476e] px-5 py-3 rounded-lg transition-colors duration-200">
                <a href="{{ route('archived-file.show') }}" class="flex items-center gap-4 w-full">
                    <img src="{{ asset('images/navigation/archive.png') }}" alt="Archived Files" class="w-14">
                    <span class="text-lg font-semibold text-gray-200">Archived</span>
                </a>
            </li>


            @if (!Auth::user()->isAdmin)
                <li
                    class="flex items-center space-x-4 hover:bg-[#47476e] px-5 py-3 rounded-lg transition-colors duration-200">
                    <a href="{{ route('shared-with-me') }}" class="flex items-center gap-4 w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="w-10 text-gray-300">
                            <path fill-rule="evenodd"
                                d="M15.75 4.5a3 3 0 1 1 .825 2.066l-8.421 4.679a3.002 3.002 0 0 1 0 1.51l8.421 4.679a3 3 0 1 1-.729 1.31l-8.421-4.678a3 3 0 1 1 0-4.132l8.421-4.679a3 3 0 0 1-.096-.755Z"
                                clip-rule="evenodd" />
                        </svg>

                        <span class="text-lg font-semibold text-gray-200">Share with me</span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->isAdmin)
                <li
                    class="flex items-center space-x-4 hover:bg-[#47476e] px-5 py-3 rounded-lg transition-colors duration-200">
                    <a href="{{ route('report.show') }}" class="flex items-center gap-4 w-full">
                        <img src="{{ asset('images/navigation/report2.png') }}" alt="Archived Files" class="w-10 ml-4">
                        <span class="text-lg font-semibold text-gray-200">Reports</span>
                    </a>
                </li>
                <li
                    class="flex items-center space-x-4 hover:bg-[#47476e] px-5 py-3 rounded-lg transition-colors duration-200">
                    <a href="{{ route('client.records.show') }}" class="flex items-center gap-4 w-full">
                        <img src="{{ asset('images/navigation/client-search.png') }}" alt="Archived Files"
                            class="w-14">

                        <span class="text-lg font-semibold text-gray-200">Client file search</span>
                    </a>
                </li>
            @endif


        </ul>


    </div>

</aside>
