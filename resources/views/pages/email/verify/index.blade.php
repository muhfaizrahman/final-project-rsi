<!doctype html>
<html>
@include('components.head')
<body>
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md mx-auto text-center">
            
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Verifikasi Email Kamu</h2>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('message'))
                <div class="mb-4 p-4 bg-gray-100 text-gray-700 rounded-lg">
                    {{ session('message') }}
                </div>
            @endif

            <p class="text-gray-600 mb-8 leading-relaxed">
                Kami sudah mengirimkan link verifikasi ke email kamu. 
                Silakan cek inbox (atau folder spam) untuk menyelesaikan proses registrasi.
            </p>

            <form method="POST" action="{{ route('verification.send') }}" class="mb-6">
                @csrf
                <button type="submit"
                    class="w-full bg-[#7E794B] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#6B6840] transition duration-150 shadow-md cursor-pointer">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <div class="text-gray-500 text-sm mt-4">
                Sudah verifikasi email kamu?
                <a href="{{ route('loginPage') }}" class="text-[#7E794B] font-semibold hover:text-[#6B6840] hover:underline transition duration-150">
                    Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</body>
</html>