<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body>
    <div class="max-w-2xl w-full mx-auto py-8">
        <h1 class="text-4xl font-bold mb-6">Apply Lowongan</h1>

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

        <div class="bg-white p-8 rounded-xl shadow-lg space-y-4">

            <section class="flex items-center space-x-4">
                <div class="size-24 flex items-center justify-center">
                    <img class="object-cover" src="{{ asset('assets/images/default-experience.png') }}" alt="">
                </div>
                <div class="space-y-1">
                    <h2 class="text-xl font-bold">{{ $job->title }}</h2>
                    <p class="text-sm">{{ $job->company->name }}</p>
                    <span class="text-sm text-gray-600">{{ $job->city }}, {{ $job->country }} ({{ $job->workMethod->name }})</span>
                </div>
            </section>

            <h3 class="text-lg font-semibold">Informasi Pribadi</h3>

            <form action="{{ route('submitApplication', $job->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <input type="hidden" name="job_id" value="{{ $job->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">Nama Depan</label>
                        <input type="text" id="firstName" name="first_name" value="{{ old('first_name') }}" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#7E794B]">
                    </div>
                    <div>
                        <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">Nama Belakang</label>
                        <input type="text" id="lastName" name="last_name" value="{{ old('last_name') }}"  class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#7E794B]">
                    </div>
                </div>

                <div>
                    <label for="domicile" class="block text-sm font-medium text-gray-700 mb-1">Domisili Saat Ini</label>
                    <input type="text" id="domicile" name="domicile" value="{{ old('domicile') }}"  class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#7E794B]">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon Aktif</label>
                        <input type="tel" id="phone" name="applicant_phone" value="{{ old('applicant_phone') }}"  class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#7E794B]">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Aktif</label>
                        <input type="email" id="email" name="applicant_email" value="{{ old('applicant_email') }}"  class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#7E794B]">
                    </div>
                </div>

                <div class="">
                    <label for="cvUpload" class="block text-sm font-medium text-gray-700 mb-1">Unggah CV Terbaru</label>
                    <input type="file" id="cvUpload" name="cv_url" placeholder="Pilih file..." class="w-full p-2 border border-gray-300 rounded-lg text-gray-500 w-full text-sm text-gray-500 file:mr-2 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-500 hover:file:bg-gray-300 file:cursor-pointer">
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="w-32 py-2 px-4 rounded-lg text-white font-medium shadow-md transition duration-150 bg-[#7E794B] hover:bg-[#6e6a3f] cursor-pointer ml-auto">
                        Submit
                    </button>
                </div>
            </form>

        </div>
    </div>
</body>
</html>