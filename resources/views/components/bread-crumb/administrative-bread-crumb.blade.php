<!-- He who is contented is rich. - Laozi -->
{{-- <nav aria-label="Breadcrumb">
    <ol class="flex space-x-2 text-sm text-gray-600">
        <li><a href="{{ route('file-manager.show') }}"><span class="">Administrative Reports</span></a>
        </li>
        <li><span class="text-gray-400"> &gt; </span></li>
        <li><a class="font-bold">{{ $record }}</a></li>
    </ol>
</nav> --}}
<nav class="w-max flex px-5 p-2 text-gray-700 rounded-lg" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
        <li class="inline-flex items-center">
            <a href="{{ route('administrative.show') }}"
                class="{{ Route::is('administrative.show') ? 'text-blue-600 inline-flex items-center text-sm font-medium hover:text-blue-600 ms-2' : 'ms-2 inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-700' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd"
                        d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z"
                        clip-rule="evenodd" />
                    <path
                        d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                </svg>
                {{ ucwords(str_replace('-', ' ', $record ?: 'Record')) }}
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                </svg>
                <a href="{{ $record ? route('administrative.record.show', $record) : 'javascript:void(0);' }}"
                    class="{{ Route::is('administrative.record.show') ? 'text-blue-600 inline-flex items-center text-sm font-medium hover:text-blue-600 ms-2' : 'ms-2 inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-700' }}
                        {{ !$record && !Route::is('administrative.record.show') ? 'pointer-events-none cursor-not-allowed' : 'text-blue-600' }}">
                    Files
                </a>
            </div>
        </li>
    </ol>
</nav>

<!-- Breadcrumb -->
