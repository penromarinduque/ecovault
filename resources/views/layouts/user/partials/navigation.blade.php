<header class="h-20 w-full bg-white fixed top-0 left-0 z-10">
    <nav class="flex justify-between space-x-4 h-full mx-8">
        <div class="flex space-x-4 items-center">
            <img src="{{ asset('images/logo.png') }}" class="w-14" alt="">
            <div class="font-medium text-xl text-black"> 
                <h1>Document Security and Digital Archiving System</h1>
               
            </div>
        </div>
            
        <div class="flex space-x-4 items-center relative"> 
            <button class="bg-white px-4 flex items-center py-1 rounded-md" id="adminBtn">
                <i class='bx bxs-user-circle bx-md mr-2'></i> Admin
                <i class='bx bx-chevron-down'></i>
            </button>

            <!-- Dropdown Menu -->
            <div id="dropdown" class="border border-black absolute right-0 top-16 hidden bg-white shadow-lg rounded mt-2 w-48">
                <ul class="flex flex-col m-2">
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Options</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<script>
    // JavaScript to toggle dropdown visibility
    const adminBtn = document.getElementById('adminBtn');
    const dropdown = document.getElementById('dropdown');

    adminBtn.addEventListener('click', () => {
        dropdown.classList.toggle('hidden');
    });

    // Optional: Close dropdown if clicked outside
    window.addEventListener('click', (event) => {
        if (!adminBtn.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
