<aside class="sidebar bg-white shadow-lg w-full lg:w-64 border-r border-gray-200 p-4 fixed lg:relative z-10 -translate-x-full lg:translate-x-0" id="sidebar">
    <!-- Logo/Nama Aplikasi -->
    <div class="mb-8 p-2 flex flex-col">
        <a href="{{ route('companyDashboardPage') }}" class="flex items-center justify-center">
            <img class="w-30" src="{{ asset('assets/images/Lunaris.png') }}" alt="">
        </a>
    </div>
    
    <!-- Navigasi Utama -->
    <nav>
        <a href="#" class="block py-2 px-4 rounded-lg font-medium text-white bg-green-700 shadow-md transition duration-150 mb-2">
            Lowongan
        </a>
        <a href="#" class="block py-2 px-4 rounded-lg font-medium text-gray-600 hover:bg-gray-100 transition duration-150">
            Event
        </a>
    </nav>
</aside>