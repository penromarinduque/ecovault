 <script>
     const isAdmin = {!! json_encode(auth()->check() && auth()->user()->isAdmin) !!};
     // Function to handle fading out and in sections
     const type = {!! json_encode($type) !!};
     const municipality = {!! json_encode($municipality) !!};
     const isArchived = false; // Define any other variables here if needed
 </script>
 <script src="{{ asset('js/file-manager/file-manager.js') }}"></script>
 <script src="{{ asset('js/file-manager/file-share.js') }}"></script>
 <script src="{{ asset('js/file-modal.js') }}"></script>
