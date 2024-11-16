@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')


    @component('components.bread-crumb.file-manager-bread-crumb', [
        'type' => $type ?? '',
        'category' => $category ?? '',
        'municipality' => $municipality ?? '',
    ])
    @endcomponent
    <div class="h-[calc(90vh-100px)] rounded-md text-black p-4 bg-white shadow-md border border-300 mt-2">
        <h1 class="font-medium  text-2xl text-gray-500">Environmental Permits and Land Records Folder</h1>

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
                                'text-center', 'mx-auto');

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
