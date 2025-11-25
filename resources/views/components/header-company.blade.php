<div class="flex bg-white justify-end items-center py-4 px-6 border-b border-gray-200 shadow-lg">
    <div class="flex space-x-4">
        <!-- Tombol Tambah Lowongan -->
        <a href="{{ route('createJobPage') }}" class="flex items-center justify-center p-3 w-10 h-10 rounded-full bg-[#7E794B] hover:bg-[#6B6840] text-white shadow-lg transition duration-200 ease-in-out cursor-pointer">
            <i class="bi bi-plus text-2xl font-bold"></i>
        </a>
        <!-- Tombol Profil Pengguna -->
        <div class="relative">
            <button id="user-avatar-btn" class="focus:outline-none rounded-full" aria-expanded="false" aria-haspopup="true">
                <img src="{{ auth()->user()->company?->profile_photo_url 
                ? asset('storage/' . auth()->user()->company->profile_photo_url) 
                : asset('assets/images/default-profile-picture.jpg') }}" alt="User Avatar" class="h-10 w-10 rounded-full object-cover border-2 border-gray-300 hover:border-[#7E794B] transition duration-150 cursor-pointer">
            </button>

            <div id="user-dropdown-menu" 
                class="hidden absolute right-0 mt-3 w-48 bg-white rounded-lg shadow-xl py-1 z-50 border border-gray-100"
                role="menu" aria-orientation="vertical" aria-labelledby="user-avatar-btn" tabindex="-1">
                
                <a href="{{ route('companyProfilePage', auth()->user()) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">
                    Profil
                </a>
                
                <div class="border-t border-gray-200 my-1"></div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 cursor-pointer" role="menuitem" tabindex="-1">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const avatarButton = document.getElementById('user-avatar-btn');
        const dropdownMenu = document.getElementById('user-dropdown-menu');

        // Fungsi untuk mengaktifkan/menonaktifkan dropdown
        avatarButton.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true' || false;
            this.setAttribute('aria-expanded', !isExpanded);
            dropdownMenu.classList.toggle('hidden');
        });

        // Menutup dropdown jika user mengklik di luar area menu
        document.addEventListener('click', function(event) {
            if (!avatarButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
                avatarButton.setAttribute('aria-expanded', 'false');
            }
        });
    });
</script>