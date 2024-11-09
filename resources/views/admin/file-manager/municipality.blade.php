@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <div class="bg-slate-200 h-[600px] rounded-md text-black p-4">


        <nav aria-label="Breadcrumb">
            <ol class="flex space-x-2 text-sm text-gray-600">
                <!-- Always show the type -->
                <li>
                    <span class=""> Permits and Registration Documents </span>
                </li>
                <li>
                    <span class="text-gray-400"> &gt; </span>
                </li>
                <li>
                    <a>{{ ucwords(str_replace('-', ' ', $type)) }}</a>
                </li>

                <!-- Show the category if it exists -->
                @if (isset($category))
                    <li>
                        <span class="text-gray-400"> &gt; </span>
                    </li>
                    <li>
                        <a>{{ ucwords(str_replace('-', ' ', $category)) }}</a>
                    </li>
                @endif

                <!-- Municipality is always the last breadcrumb item -->
                <li>
                    <span class="text-gray-400"> &gt; </span>
                </li>
                <li>
                    <a class="font-bold">Municipality</a>
                </li>
            </ol>
        </nav>

        <h1 class="font-medium  text-2xl text-gray-700">Environmental Permits and Land Records Folder</h1>

        <!-- Dynamic Grid Container for JavaScript to populate -->
        <div id="municipalities-container" class="grid grid-cols-4 gap-8 m-16 text-gray-700 font-semibold">
            <!-- JavaScript will populate this container -->
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('municipalities-container');

                // Loading indicator
                container.innerHTML = '<p class="col-span-4 text-center text-gray-600">Loading municipalities...</p>';

                fetch('/api/municipalities')
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        // Clear container before adding fetched items
                        container.innerHTML = '';

                        // Populate with fetched municipalities
                        data.locations.forEach(municipality => {
                            const municipalityDiv = document.createElement('div');
                            municipalityDiv.classList.add('flex', 'flex-col', 'items-center',
                                'text-center');

                            municipalityDiv.innerHTML = `
                        <a href="${encodeURI(municipality.location)}" class="text-center">
                            <img src="{{ asset('images/admin/folder.png') }}" alt="Municipality Folder" class="w-24 mb-2">
                            <h2 class="w-[120px]">${municipality.location}</h2>
                        </a>
                    `;

                            container.appendChild(municipalityDiv);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching municipalities:', error);
                        container.innerHTML =
                            '<p class="col-span-4 text-center text-red-600">Error loading municipalities. Please try again later.</p>';
                    });
            });
        </script>

    </div>




@endsection
