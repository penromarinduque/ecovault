@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <div class="bg-slate-200 h-[600px] rounded-md text-black p-4 ">


        <nav aria-label="Breadcrumb">
            <ol class="flex space-x-2 text-sm text-gray-600">
                <!-- Always show the type -->
                <li>
                    <span class=""> File Manager </span>
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



        <div class="grid grid-cols-5 m-16 gap-4" id="municipalities-container">

        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                fetch('/api/municipalities')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const container = document.getElementById('municipalities-container');

                        // Clear existing content in case of multiple loads
                        container.innerHTML = '';

                        // Iterate over each municipality and create HTML
                        data.locations.forEach(municipality => {
                            const municipalityDiv = document.createElement('div');
                            municipalityDiv.classList.add('text-center');

                            municipalityDiv.innerHTML = `
                        <a href="${encodeURI(municipality.location)}">
                            <img src="{{ asset('images/admin/folder.png') }}" alt="" class="w-24 mx-auto">
                            <h1 class="w-[120px] mx-auto">${municipality.location}</h1>
                        </a>
                    `;

                            container.appendChild(municipalityDiv);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching municipalities:', error);
                    });
            });
        </script>
    </div>




@endsection
