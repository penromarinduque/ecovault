@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <div class="h-[600px] rounded-md text-black p-4 ">





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
