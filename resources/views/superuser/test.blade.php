@extends('layouts.admin.master')

@section('title', 'PENRO Archiving System')

@section('content')

    Super User Admin


    <form id="uploadForm">
        <label for="file">Choose a file:</label>
        <input type="file" id="file" name="file" required>
        <button type="submit">Upload</button>
    </form>

    <div id="result" style="display:none;">
        <h3>QR Code Generated:</h3>
        <img id="qrCodeImage" alt="QR Code">
        <p>File uploaded successfully! <a id="downloadLink" href="#" download>Download File</a></p>
    </div>

    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData();
            const fileField = document.querySelector('input[type="file"]');
            formData.append('file', fileField.files[0]);

            fetch('/file-upload/test', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure this is added if using Blade template
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.file_path && data.qr_code_path) {
                        // Display the QR code image
                        const qrCodeImage = document.getElementById('qrCodeImage');
                        qrCodeImage.src = `/storage/${data.qr_code_path}`;

                        // Provide download link for the uploaded file
                        const downloadLink = document.getElementById('downloadLink');
                        downloadLink.href = `/download/12`; // This should be dynamic when a DB is added

                        document.getElementById('result').style.display = 'block';
                    } else {
                        alert('Error: File upload or QR code generation failed.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while uploading the file.');
                });
        });
    </script>
@endsection
