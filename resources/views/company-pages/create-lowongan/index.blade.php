<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body class="flex flex-col items-center p-8 bg-gray-50">
    <div class="w-full max-w-2xl">
        <h1 class="text-4xl font-bold mb-6 text-gray-800">Buat Lowongan</h1>
    
        <div class="bg-white shadow-xl rounded-lg p-6">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex items-center mb-8 pb-4 border-b border-gray-200">
                <div class="size-16 rounded-full flex items-center justify-center mr-3 overflow-hidden">
                    <!-- Gunakan logo perusahaan yang sudah ada -->
                    <img src="{{ auth()->user()->company?->profile_photo_url 
                        ? asset('storage/' . auth()->user()->company->profile_photo_url) 
                        : asset('assets/images/default-profile-picture.jpg') }}" 
                        alt="Company Logo" class="w-full h-full object-cover">
                </div>
                <!-- Nama perusahaan diambil dari user yang sedang login -->
                <h2 class="text-xl font-bold text-gray-800">{{ auth()->user()->company?->name ?? 'Default Company' }}</h2>
            </div>
    
            <!-- Action diarahkan ke route jobs.store -->
            <form action="{{ route('storeJob') }}" method="POST" class="space-y-6">
                @csrf
    
                <!-- Nama Posisi (title) -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Nama posisi</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#7E794B] focus:border-[#7E794B] sm:text-sm" placeholder="Contoh: Senior Backend Developer">
                </div>
    
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tipe Tempat Kerja (work_method_id - Dropdown) -->
                    <div>
                        <label for="work_method_id" class="block text-sm font-medium text-gray-700 mb-1">Tipe tempat kerja</label>
                        <select name="work_method_id" id="work_method_id"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#7E794B] focus:border-[#7E794B] sm:text-sm">
                            <option value="" disabled selected>Pilih Tipe Tempat Kerja</option>
                            <!-- Data diambil dari Controller -->
                            @foreach ($workMethods as $method)
                                <option value="{{ $method->id }}" {{ old('work_method_id') == $method->id ? 'selected' : '' }}>
                                    {{ $method->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
        
                    <!-- Tipe Pekerjaan (work_type_id - Dropdown) -->
                    <div>
                        <label for="work_type_id" class="block text-sm font-medium text-gray-700 mb-1">Tipe pekerjaan</label>
                        <select name="work_type_id" id="work_type_id"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#7E794B] focus:border-[#7E794B] sm:text-sm">
                            <option value="" disabled selected>Pilih Tipe Pekerjaan</option>
                            <!-- Data diambil dari Controller -->
                            @foreach ($workTypes as $type)
                                <option value="{{ $type->id }}" {{ old('work_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Input Industri (industry_id - Dropdown) -->
                <div>
                    <label for="industry_id" class="block text-sm font-medium text-gray-700 mb-1">Industri</label>
                    <select name="industry_id" id="industry_id"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#7E794B] focus:border-[#7E794B] sm:text-sm">
                        <option value="" disabled selected>Pilih Industri</option>
                        <!-- Data diambil dari Controller -->
                        @foreach ($industries as $industry)
                            <option value="{{ $industry->id }}" {{ old('industry_id') == $industry->id ? 'selected' : '' }}>
                                {{ $industry->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Deskripsi Lowongan -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi lowongan</label>
                    <textarea id="description" name="description" rows="6" 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#7E794B] focus:border-[#7E794B] sm:text-sm" placeholder="Tuliskan tanggung jawab pekerjaan secara rinci.">{{ old('description') }}</textarea>
                </div>
    
                <!-- Requirement Lowongan -->
                <div>
                    <label for="requirements" class="block text-sm font-medium text-gray-700 mb-1">Requirement lowongan</label>
                    <textarea id="requirements" name="requirements" rows="6" 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#7E794B] focus:border-[#7E794B] sm:text-sm" placeholder="Sebutkan kualifikasi, skill, dan pengalaman yang dibutuhkan.">{{ old('requirements') }}</textarea>
                </div>
    
                <!-- Tombol Submit -->
                <div class="pt-2 flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-md text-base font-medium rounded-md text-white bg-[#7E794B] hover:bg-[#6B6A3F] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#7E794B] cursor-pointer">
                        Buat Lowongan
                    </button>
                </div>
                
            </form>
        </div>
    </div>
</body>
</html>