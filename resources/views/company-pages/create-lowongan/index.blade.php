<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body class="flex flex-col items-center p-8">
    <div class="w-full max-w-2xl">
        <h1 class="text-4xl font-bold mb-6">Buat Lowongan</h1>
    
        <div class=" bg-white shadow-xl rounded-lg p-6">
            
            <div class="flex items-center mb-8">
                <div class="size-24 rounded-full flex items-center justify-center mr-3">
                    <img src="{{ auth()->user()->companyProfile?->profile_photo_url 
                    ? asset('storage/' . auth()->user()->companyProfile->profile_photo_url) 
                    : asset('assets/images/default-profile-picture.jpg') }}" alt="User Avatar" class="w-full object-cover overflow-hidden rounded-full">
                </div>
                <h2 class="text-xl font-bold">Perusahaan Tokopedia</h2>
            </div>
    
            <form action="#" method="POST" class="space-y-6">
    
                <div>
                    <label for="nama_posisi" class="block text-sm font-medium text-gray-700 mb-1">Nama posisi</label>
                    <input type="text" name="nama_posisi" id="nama_posisi" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="">
                </div>
    
                <div>
                    <label for="tipe_tempat_kerja" class="block text-sm font-medium text-gray-700 mb-1">Tipe tempat kerja</label>
                    <input type="text" name="tipe_tempat_kerja" id="tipe_tempat_kerja" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="">
                </div>
    
                <div>
                    <label for="lokasi_tempat_kerja" class="block text-sm font-medium text-gray-700 mb-1">Lokasi tempat kerja</label>
                    <input type="text" name="lokasi_tempat_kerja" id="lokasi_tempat_kerja" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="">
                </div>
    
                <div>
                    <label for="tipe_pekerjaan" class="block text-sm font-medium text-gray-700 mb-1">Tipe pekerjaan</label>
                    <input type="text" name="tipe_pekerjaan" id="tipe_pekerjaan" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="">
                </div>
    
                <div>
                    <label for="deskripsi_lowongan" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi lowongan</label>
                    <textarea id="deskripsi_lowongan" name="deskripsi_lowongan" rows="6" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder=""></textarea>
                </div>
    
                <div>
                    <label for="requirement_lowongan" class="block text-sm font-medium text-gray-700 mb-1">Requirement lowongan</label>
                    <textarea id="requirement_lowongan" name="requirement_lowongan" rows="6" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder=""></textarea>
                </div>
    
                <div class="pt-2">
                    <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" style="background-color: #79844f; /* Warna kustom mendekati gambar */">
                        Submit
                    </button>
                </div>
                
            </form>
        </div>
    </div>

</body>
</html>