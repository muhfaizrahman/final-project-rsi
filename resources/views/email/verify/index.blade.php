<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  </head>
  <body>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
        <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Verifikasi Email Kamu</h2>

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('message'))
                <div class="mb-4 p-3 bg-blue-100 text-blue-700 rounded-lg">
                    {{ session('message') }}
                </div>
            @endif

            <p class="text-gray-600 mb-6">
                Kami sudah mengirimkan link verifikasi ke email kamu.  
                Silakan cek inbox (atau folder spam) untuk menyelesaikan proses registrasi.
            </p>

            <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                @csrf
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <div class="text-gray-500 text-sm mt-4">
                Sudah verifikasi email kamu?  
                <a href="{{ route('loginPage') }}" class="text-blue-600 font-semibold hover:underline">
                    Kembali ke Login
                </a>
            </div>
        </div>
    </div>
  </body>
</html>