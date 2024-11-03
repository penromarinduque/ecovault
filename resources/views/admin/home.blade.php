@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="bg-[#D9D9D9] h-[600px] rounded-md text-black p-4">
        <h2 class="text-lg font-bold mb-4">Storage Usage</h2>

        <div class="grid grid-cols-4 gap-4">
            <!-- Card for Images -->
            <div class="bg-white p-4 rounded-lg shadow-md flex flex-col items-center">
                <img src="{{ asset('images/image.svg') }}" alt="Images" class="h-16 mb-2">
                <h2 class="text-lg font-semibold">Images</h2>
                <p class="text-xl font-bold" id="image-count">0</p> <!-- Placeholder for image count -->
            </div>



            <div class="bg-white p-4 rounded-lg shadow-md flex flex-col items-center">
                <img src="{{ asset('images/pdf.svg') }}" alt="PDFs" class="h-16 mb-2">
                <h2 class="text-lg font-semibold">PDFs</h2>
                <p class="text-xl font-bold" id="pdf-count">0</p> <!-- Placeholder for PDF count -->
            </div>

            <div class="bg-white p-4 rounded-lg shadow-md flex flex-col items-center">
                <img src="{{ asset('images/zip.svg') }}" alt="ZIP Files" class="h-16 mb-2">
                <h2 class="text-lg font-semibold">ZIP Files</h2>
                <p class="text-xl font-bold" id="zip-count">0</p> <!-- Placeholder for ZIP count -->
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4"> <!-- Three-column grid layout for flexible sizing -->
            <!-- Storage chart spans 1 column -->
            <div class="col-span-1 h-full">
                <x-storage-chart />
            </div>

            <!-- Area chart spans the remaining 2 columns -->
            <div class="col-span-2 h-full">
                <x-areaChart />
            </div>
        </div>



    </div>


    <script>
        // Fetch function to get the count of files by extension
        fetch("/files/count")
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok " + response.statusText);
                }
                return response.json(); // Parse JSON from the response
            })
            .then(data => {
                // Update the counts in the HTML
                document.getElementById("image-count").innerText = data.image_files || 0;

                document.getElementById("pdf-count").innerText = data.pdf_files || 0;
                document.getElementById("zip-count").innerText = data.zip_files || 0;

                // Optionally log the data
                console.log(data);
            })
            .catch(error => {
                console.error("There was a problem with the fetch operation:", error);
            });
    </script>






@endsection
