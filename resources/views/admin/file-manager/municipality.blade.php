@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <div class="h-[calc(90vh-100px)] rounded-md text-black p-4 bg-white shadow-md border border-300 mt-2">
        <h1 class="font-medium text-2xl text-gray-500">Environmental Permits and Land Records Folder</h1>

        <!-- Dynamic Grid Container -->
        <div id="municipalities-container" class="grid grid-cols-4 gap-8 m-16 text-gray-700 font-semibold">
            <!-- Populated by JavaScript -->
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('municipalities-container');

                // Show a loading message
                container.innerHTML = '<p class="col-span-4 text-center text-gray-600">Loading municipalities...</p>';

                // Fetch municipalities for Marinduque
                fetch('/api/municipalities')
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to fetch municipalities.');
                        return response.json();
                    })
                    .then(data => {
                        // Extract the locations array from the JSON response
                        const municipalities = data.locations;

                        // Clear the container
                        const _type = @json($type ?? '');
                        const _category = @json($category ?? '');
                        container.innerHTML = '';

                        // Populate the municipalities dynamically
                        if (municipalities.length > 0) {
                            municipalities.forEach(municipality => {
                                const municipalityDiv = document.createElement('div');
                                municipalityDiv.classList.add('flex', 'flex-col', 'items-center',
                                    'text-center', 'mx-auto');
                                const municipalityUrl =
                                    `{{ route('archived-file.file-manager.table.show', ['type' => '__type__', 'municipality' => '__municipality__', 'category' => '__category__']) }}`
                                        .replace('__type__', _type)
                                        .replace('__municipality__', municipality.location)
                                       .replace('__category__', _category ??
                                            '');
                                const imgSrc = `{{ asset('__src__') }}`.replace('__src__', municipality
                                    .img_src);
                                municipalityDiv.innerHTML = `
                            <a href="${municipalityUrl}" class="text-center">
                                <img src="${imgSrc}"  alt="${municipality.location} Folder" class="w-24 mb-2">
                                <h2 class="w-[120px] truncate">${municipality.location}</h2>
                            </a>
                        `;

                                container.appendChild(municipalityDiv);
                            });
                        } else {
                            container.innerHTML =
                                '<p class="col-span-4 text-center text-gray-600">No municipalities found.</p>';
                        }
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
