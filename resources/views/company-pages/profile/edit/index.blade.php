<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body class="min-h-screen">
    <div class="max-w-4xl mx-auto p-4 sm:p-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 pb-2">Edit Profil Perusahaan</h1>
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                <strong class="font-bold">Oops!</strong>
                <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Action diarahkan ke rute UPDATE dengan parameter $user -->
        <form action="{{ route('updateCompanyProfile', $user) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Bagian 1: Informasi Dasar Perusahaan -->
            <section class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-5 pb-3">Informasi Perusahaan</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Perusahaan -->
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan</label>
                        <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $profile->company_name) }}" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5">
                    </div>
                    
                    <!-- Kota -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Kota</label>
                        <input type="text" id="city" name="city" value="{{ old('city', $profile->city) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5">
                    </div>
                    
                    <!-- Negara -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Negara</label>
                        <input type="text" id="country" name="country" value="{{ old('country', $profile->country) }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="about" class="block text-sm font-medium text-gray-700 mb-1">Tentang Perusahaan</label>
                        <textarea id="about" name="about" rows="6"
                                     class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5">{{ old('about', $profile->about) }}</textarea>
                    </div>
                </div>
            </section>

            <!-- Bagian 2: Foto Profil & Background -->
            <section class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-5 pb-3">Logo & Background</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Logo Perusahaan -->
                    <div>
                        <label for="profile_photo_url" class="block text-sm font-medium text-gray-700 mb-1">Logo Perusahaan</label>
                        <input type="file" id="profile_photo_url" name="profile_photo_url"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @if($profile->profile_photo_url)
                            <p class="mt-2 text-sm text-gray-500 flex items-center">
                                Logo saat ini: 
                                <img src="{{ asset('storage/' . $profile->profile_photo_url) }}" class="ml-2 w-10 h-10 object-cover rounded-full border border-gray-300">
                            </p>
                        @endif
                    </div>

                    <!-- Background Banner -->
                    <div>
                        <label for="background_photo_url" class="block text-sm font-medium text-gray-700 mb-1">Background Banner</label>
                        <input type="file" id="background_photo_url" name="background_photo_url"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @if($profile->background_photo_url)
                            <p class="mt-2 text-sm text-gray-500 flex items-center">
                                Banner saat ini: 
                                <img src="{{ asset('storage/' . $profile->background_photo_url) }}" class="ml-2 w-20 h-10 object-cover rounded-md border border-gray-300">
                            </p>
                        @endif
                    </div>
                </div>
            </section>

            <!-- Tombol Simpan -->
            <div class="flex justify-end">
                <button type="submit" 
                        class="w-full md:w-auto px-6 py-3 border border-transparent text-lg font-medium rounded-xl shadow-lg text-white bg-[#7E794B] hover:bg-[#6e6a3f] focus:outline-none transition duration-300 ease-in-out cursor-pointer">
                    Simpan Perubahan Profil Perusahaan
                </button>
            </div>
        </form>
    </div>
</body>
</html>