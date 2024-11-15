@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')
    <script src="https://unpkg.com/html5-qrcode"></script>
    <div class="flex justify-center mt-10">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-xl font-semibold text-center mb-4">Custom QR Code Scanner</h2>

            <!-- Camera selection dropdown -->
            <select id="camera-select" class="w-full p-2 border border-gray-300 rounded mb-4"></select>

            <!-- QR Reader area with indicator -->
            <div id="qr-reader" class="w-full border border-gray-300 rounded mb-4 relative">
                <div id="qr-indicator" class="absolute inset-0 border-4 border-transparent rounded transition-all rounded-md">
                </div>
            </div>

            <!-- QR Code result output -->
            <div id="qr-reader-results" class="text-center text-gray-800">
                QR Code Result: <span id="output">None</span>
            </div>

            <!-- Start and Stop buttons -->
            <div class="flex justify-between mt-4">
                <button id="start-button"
                    class="bg-green-500 w-full text-white font-bold py-2 px-4 rounded hover:bg-green-600 mr-2">
                    Start Scanner
                </button>
                <button id="stop-button"
                    class="bg-red-500 w-full text-white font-bold py-2 px-4 rounded hover:bg-red-600 ml-2 hidden">
                    Stop Scanner
                </button>
            </div>

            <!-- Go to URL button (hidden by default) -->
            <button id="go-to-url-button"
                class="bg-blue-500 w-full text-white font-bold py-2 px-4 rounded hover:bg-blue-600 mt-4 hidden">
                Go to URL
            </button>
        </div>
    </div>

    <style>
        /* QR indicator styling */
        #qr-indicator.success {
            border-color: #10b981;
            /* Tailwind green-500 */
        }
    </style>

    <script>
        const output = document.getElementById('output');
        const cameraSelect = document.getElementById('camera-select');
        const startButton = document.getElementById('start-button');
        const stopButton = document.getElementById('stop-button');
        const qrIndicator = document.getElementById('qr-indicator');
        const goToUrlButton = document.getElementById('go-to-url-button');

        let html5QrCode;
        let isScanning = false;

        // Function to start scanning
        function startScanning(cameraId) {
            html5QrCode = new Html5Qrcode("qr-reader");
            html5QrCode.start(
                cameraId, {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                },
                (decodedText) => {
                    // Display the scanned result
                    output.innerText = decodedText;
                    qrIndicator.classList.add("success");

                    // Show "Go to URL" button with link to scanned URL
                    goToUrlButton.classList.remove("hidden");
                    goToUrlButton.onclick = () => {
                        // window.location.href = decodedText;
                        window.open(decodedText);
                    };

                    setTimeout(() => {
                        qrIndicator.classList.remove("success");
                    }, 500);
                },
                (errorMessage) => {
                    console.log("Scanning error:", errorMessage);
                }
            ).then(() => {
                isScanning = true;
                startButton.classList.add("hidden");
                stopButton.classList.remove("hidden");
            }).catch((err) => {
                console.error("Failed to start scanner:", err);
                alert("Could not start scanner. Check console for details.");
            });
        }

        // Function to stop scanning
        function stopScanning() {
            if (html5QrCode && isScanning) {
                html5QrCode.stop().then(() => {
                    isScanning = false;
                    startButton.classList.remove("hidden");
                    stopButton.classList.add("hidden");
                    goToUrlButton.classList.add("hidden"); // Hide "Go to URL" button when stopped
                    qrIndicator.classList.remove("success");
                }).catch((err) => {
                    console.error("Failed to stop the scanner:", err);
                });
            }
        }

        // Fetch the camera list and populate the dropdown
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                devices.forEach((device, index) => {
                    const option = document.createElement("option");
                    option.value = device.id;
                    option.text = device.label || `Camera ${index + 1}`;
                    cameraSelect.appendChild(option);
                });

                // Start scanning with the selected camera when "Start" button is clicked
                startButton.addEventListener("click", () => {
                    const selectedCameraId = cameraSelect.value;
                    startScanning(selectedCameraId);
                });

                // Stop scanning when "Stop" button is clicked
                stopButton.addEventListener("click", stopScanning);

                // Event listener for camera selection
                cameraSelect.addEventListener("change", () => {
                    if (isScanning) {
                        stopScanning();
                    }
                });
            } else {
                alert("No cameras found!");
            }
        }).catch(err => {
            console.error("Error getting cameras:", err);
        });
    </script>
@endsection
