<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body class="flex flex-col min-h-screen items-center justify-center">
    <div class="bg-white p-8 rounded-xl shadow-lg">
        <h1 class="text-4xl text-center font-bold mb-6">Welcome, Job Seekers</h1>

        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="p-4 bg-red-100 text-red-800 rounded-lg mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-4">
            <a href="{{ route('loginPage') }}" class="w-full flex justify-center border-2 py-3 px-4 rounded-lg text-lg font-bold text-[#7E794B] border-[#7E794B] hover:bg-[#7E794B] hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6B6840] transition duration-150 cursor-pointer">
                Login sebagai pelamar
            </a>
            <a href="{{ route('loginCompanyPage') }}" class="w-full flex justify-center py-3 px-4 rounded-lg text-lg font-bold text-white bg-[#7E794B] hover:bg-[#6B6840] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#6B6840] transition duration-150 cursor-pointer">
                Login sebagai perusahaan
            </a>
        </div>
    </div>
</body>
</html>