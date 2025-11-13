<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link rel="icon" href="{{ asset('assets/images/app-logo.png') }}">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 min-h-screen">

    <div class="max-w-4xl mx-auto p-4 sm:p-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-2">Edit Profil</h1>
        
        <!-- Pesan Sukses -->
        @if (session('success'))
            <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Pesan Error Validasi -->
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

        <form action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Bagian 1: Informasi Dasar -->
            <section class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-5 border-b pb-3">Informasi Dasar</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $profile->full_name) }}" 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5">
                    </div>
                    
                    <!-- Nomor Telepon -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $profile->phone) }}" 
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

                    <!-- Biografi -->
                    <div class="md:col-span-2">
                        <label for="biography" class="block text-sm font-medium text-gray-700 mb-1">Biografi Singkat</label>
                        <textarea id="biography" name="biography" rows="4"
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5">{{ old('biography', $profile->biography) }}</textarea>
                    </div>
                </div>
            </section>

            <!-- Bagian 2: Foto Profil & Background -->
            <section class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-5 border-b pb-3">Foto Profil & Background</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Foto Profil -->
                    <div>
                        <label for="profile_photo_url" class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                        <input type="file" id="profile_photo_url" name="profile_photo_url"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @if($profile->profile_photo_url)
                            <p class="mt-2 text-sm text-gray-500 flex items-center">
                                Foto saat ini: 
                                <img src="{{ asset('storage/' . $profile->profile_photo_url) }}" class="ml-2 w-10 h-10 object-cover rounded-full border border-gray-300">
                            </p>
                        @endif
                    </div>

                    <!-- Background Profil -->
                    <div>
                        <label for="background_photo_url" class="block text-sm font-medium text-gray-700 mb-1">Background Profil (Banner)</label>
                        <input type="file" id="background_photo_url" name="background_photo_url"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @if($profile->background_photo_url)
                            <p class="mt-2 text-sm text-gray-500 flex items-center">
                                Background saat ini: 
                                <img src="{{ asset('storage/' . $profile->background_photo_url) }}" class="ml-2 w-20 h-10 object-cover rounded-md border border-gray-300">
                            </p>
                        @endif
                    </div>
                </div>
            </section>

            <!-- Bagian 3: Skills -->
            <section class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-5 border-b pb-3">Skills</h2>
                <div id="skills-container" class="space-y-3">
                    @php $skill_index = 0; @endphp
                    @forelse($profile->skills as $index => $skill)
                        <div class="skill-input flex gap-2 items-center">
                            <input type="text" name="skills[]" value="{{ old('skills.'.$index, $skill->name) }}" placeholder="Nama Skill"
                                   class="flex-grow border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5">
                            <button type="button" onclick="this.parentNode.remove()" 
                                    class="text-red-600 hover:text-red-800 text-sm font-medium py-2 px-3 transition duration-150 ease-in-out rounded-lg hover:bg-red-50">Hapus</button>
                        </div>
                        @php $skill_index++; @endphp
                    @empty
                        <div class="skill-input flex gap-2 items-center">
                            <input type="text" name="skills[]" placeholder="Nama Skill"
                                   class="flex-grow border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5">
                            <button type="button" onclick="this.parentNode.remove()" 
                                    class="text-red-600 hover:text-red-800 text-sm font-medium py-2 px-3 transition duration-150 ease-in-out rounded-lg hover:bg-red-50">Hapus</button>
                        </div>
                    @endforelse
                </div>
                <button type="button" onclick="addSkillInput()" 
                        class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Tambah Skill
                </button>
            </section>

            <!-- Bagian 4: Edukasi -->
            <section class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-5 border-b pb-3">Edukasi</h2>
                <div id="educations-container" class="space-y-6">
                    @php $education_index = 0; @endphp
                    @forelse($profile->educations as $index => $education)
                        <div class="education-input p-4 border border-indigo-200 bg-indigo-50 rounded-lg space-y-3 relative">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <input type="text" name="educations[{{ $index }}][institution_name]" placeholder="Institusi (mis: University of Brawijaya)" 
                                       value="{{ old('educations.'.$index.'.institution_name', $education->institution_name) }}"
                                       class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                                <input type="text" name="educations[{{ $index }}][degree]" placeholder="Gelar (mis: S1 Ilmu Komputer)" 
                                       value="{{ old('educations.'.$index.'.degree', $education->degree) }}"
                                       class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                                <input type="text" name="educations[{{ $index }}][field_of_study]" placeholder="Bidang Studi (mis: Ilmu Komputer)" 
                                       value="{{ old('educations.'.$index.'.field_of_study', $education->field_of_study) }}"
                                       class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                                <input type="text" name="educations[{{ $index }}][city]" placeholder="Kota Institusi (mis: Malang)" 
                                       value="{{ old('educations.'.$index.'.city', $education->city) }}"
                                       class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Mulai</label>
                                    <input type="date" name="educations[{{ $index }}][start_date]" 
                                           value="{{ old('educations.'.$index.'.start_date', $education->start_date) }}"
                                           class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Selesai (atau Sekarang)</label>
                                    <input type="date" name="educations[{{ $index }}][end_date]" 
                                           value="{{ old('educations.'.$index.'.end_date', $education->end_date) }}"
                                           class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                                </div>
                            </div>
                            
                            <textarea name="educations[{{ $index }}][description]" placeholder="Deskripsi atau pencapaian (Opsional)" rows="3"
                                      class="w-full border-gray-300 rounded-lg p-2.5 text-sm">{{ old('educations.'.$index.'.description', $education->description) }}</textarea>

                            <button type="button" onclick="removeEducationInput(this)" 
                                    class="absolute top-2 right-2 text-red-500 hover:text-red-700 p-1 rounded-full transition duration-150 ease-in-out">
                                <!-- Icon X -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        @php $education_index++; @endphp
                    @empty
                        <div class="education-input p-4 border border-indigo-200 bg-indigo-50 rounded-lg space-y-3 relative">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <input type="text" name="educations[0][institution_name]" placeholder="Institusi" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                                <input type="text" name="educations[0][degree]" placeholder="Gelar" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                                <input type="text" name="educations[0][field_of_study]" placeholder="Bidang Studi" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                                <input type="text" name="educations[0][city]" placeholder="Kota Institusi" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Mulai</label>
                                    <input type="date" name="educations[0][start_date]" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Selesai (atau Sekarang)</label>
                                    <input type="date" name="educations[0][end_date]" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                                </div>
                            </div>
                            <textarea name="educations[0][description]" placeholder="Deskripsi atau pencapaian (Opsional)" rows="3" class="w-full border-gray-300 rounded-lg p-2.5 text-sm"></textarea>
                            <button type="button" onclick="removeEducationInput(this)" class="absolute top-2 right-2 text-red-500 hover:text-red-700 p-1 rounded-full transition duration-150 ease-in-out">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @endforelse
                </div>
                <button type="button" onclick="addEducationInput()" 
                        class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Tambah Edukasi
                </button>
            </section>

            <!-- Bagian 5: Experiences -->
            <section class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800 mb-5 border-b pb-3">Pengalaman</h2>
                <div id="experiences-container" class="space-y-6">
                    @php $experience_index = 0; @endphp
                    @forelse($profile->experiences as $index => $experience)
                        <div class="experience-input p-4 border border-indigo-200 bg-indigo-50 rounded-lg space-y-3 relative">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <input type="text" name="experiences[{{ $index }}][experience_title]" placeholder="Institusi (mis: University of Brawijaya)" 
                                       value="{{ old('experiences.'.$index.'.experience_title', $experience->experience_title) }}"
                                       class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                                <input type="text" name="experiences[{{ $index }}][organization_name]" placeholder="Organisasi (mis: PT. XYZ)" 
                                       value="{{ old('experiences.'.$index.'.organization_name', $experience->organization_name) }}"
                                       class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Mulai</label>
                                    <input type="date" name="experiences[{{ $index }}][start_date]" 
                                           value="{{ old('experiences.'.$index.'.start_date', $experience->start_date) }}"
                                           class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Selesai (atau Sekarang)</label>
                                    <input type="date" name="experiences[{{ $index }}][end_date]" 
                                           value="{{ old('experiences.'.$index.'.end_date', $experience->end_date) }}"
                                           class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                                </div>
                            </div>
                            
                            <textarea name="experiences[{{ $index }}][description]" placeholder="Deskripsi atau pencapaian (Opsional)" rows="3"
                                      class="w-full border-gray-300 rounded-lg p-2.5 text-sm">{{ old('experiences.'.$index.'.description', $experience->description) }}</textarea>

                            <button type="button" onclick="removeExperienceInput(this)" 
                                    class="absolute top-2 right-2 text-red-500 hover:text-red-700 p-1 rounded-full transition duration-150 ease-in-out">
                                <!-- Icon X -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        @php $experience_index++; @endphp
                    @empty
                        <div class="experience-input p-4 border border-indigo-200 bg-indigo-50 rounded-lg space-y-3 relative">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <input type="text" name="experiences[0][experience_title]" placeholder="Judul Pengalaman" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                                <input type="text" name="experiences[0][organization_name]" placeholder="Perusahaan atau Organisasi" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Mulai</label>
                                    <input type="date" name="experiences[0][start_date]" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Selesai (atau Sekarang)</label>
                                    <input type="date" name="experiences[0][end_date]" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                                </div>
                            </div>
                            <textarea name="experiences[0][description]" placeholder="Deskripsi atau pencapaian (Opsional)" rows="3" class="w-full border-gray-300 rounded-lg p-2.5 text-sm"></textarea>
                            <button type="button" onclick="removeExperienceInput(this)" class="absolute top-2 right-2 text-red-500 hover:text-red-700 p-1 rounded-full transition duration-150 ease-in-out">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @endforelse
                </div>
                <button type="button" onclick="addExperienceInput()" 
                        class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Tambah Pengalaman
                </button>
            </section>

            <!-- Tombol Simpan -->
            <div class="pt-4">
                <button type="submit" 
                        class="w-full md:w-auto px-6 py-3 border border-transparent text-lg font-medium rounded-xl shadow-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300 ease-in-out transform hover:scale-[1.01] active:scale-[0.99]">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>

    <script>
        // Mencari index tertinggi dari input edukasi yang sudah ada
        function getNextEducationIndex() {
            const container = document.getElementById('educations-container');
            const inputs = container.querySelectorAll('.education-input');
            let maxIndex = -1;
            
            inputs.forEach(input => {
                const nameAttribute = input.querySelector('input[name*="[institution_name]"]').getAttribute('name');
                const match = nameAttribute.match(/\[(\d+)\]/);
                if (match) {
                    const index = parseInt(match[1]);
                    if (index > maxIndex) {
                        maxIndex = index;
                    }
                }
            });
            return maxIndex + 1;
        }

        // Logika untuk menambahkan input Skill baru
        function addSkillInput() {
            const container = document.getElementById('skills-container');
            const newDiv = document.createElement('div');
            newDiv.className = 'skill-input flex gap-2 items-center';
            
            newDiv.innerHTML = `
                <input type="text" name="skills[]" placeholder="Nama Skill Baru" 
                        class="flex-grow border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5">
                <button type="button" onclick="this.parentNode.remove()" 
                        class="text-red-600 hover:text-red-800 text-sm font-medium py-2 px-3 transition duration-150 ease-in-out rounded-lg hover:bg-red-50">Hapus</button>
            `;
            container.appendChild(newDiv);
        }

        // Logika untuk menambahkan input Education baru
        function addEducationInput() {
            const container = document.getElementById('educations-container');
            const newIndex = getNextEducationIndex();
            const newDiv = document.createElement('div');
            newDiv.className = 'education-input p-4 border border-indigo-200 bg-indigo-50 rounded-lg space-y-3 relative';
            
            newDiv.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <input type="text" name="educations[${newIndex}][institution_name]" placeholder="Institusi" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                    <input type="text" name="educations[${newIndex}][degree]" placeholder="Gelar" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                    <input type="text" name="educations[${newIndex}][field_of_study]" placeholder="Bidang Studi" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                    <input type="text" name="educations[${newIndex}][city]" placeholder="Kota Institusi" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Mulai</label>
                        <input type="date" name="educations[${newIndex}][start_date]" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Selesai (atau Sekarang)</label>
                        <input type="date" name="educations[${newIndex}][end_date]" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                    </div>
                </div>
                <textarea name="educations[${newIndex}][description]" placeholder="Deskripsi atau pencapaian (Opsional)" rows="3" class="w-full border-gray-300 rounded-lg p-2.5 text-sm"></textarea>
                <button type="button" onclick="removeEducationInput(this)" class="absolute top-2 right-2 text-red-500 hover:text-red-700 p-1 rounded-full transition duration-150 ease-in-out">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            `;
            container.appendChild(newDiv);
        }

        // Logika untuk menghapus input Education
        function removeEducationInput(buttonElement) {
            buttonElement.closest('.education-input').remove();
            // PENTING: Setelah menghapus, kita harus memastikan index name input berurutan lagi
            reindexEducationInputs();
        }

        // Fungsi untuk memastikan array educations memiliki index berurutan setelah penghapusan
        function reindexEducationInputs() {
            const container = document.getElementById('educations-container');
            const inputs = container.querySelectorAll('.education-input');
            
            inputs.forEach((input, index) => {
                input.querySelectorAll('input, textarea').forEach(field => {
                    const originalName = field.getAttribute('name');
                    // Ganti index lama dengan index baru
                    const newName = originalName.replace(/educations\[\d+\]/g, `educations[${index}]`);
                    field.setAttribute('name', newName);
                });
            });
        }

        // Mencari index tertinggi dari input experience yang sudah ada
        function getNextExperienceIndex() {
            const container = document.getElementById('experiences-container');
            const inputs = container.querySelectorAll('.experience-input');
            let maxIndex = -1;
            
            inputs.forEach(input => {
                const nameAttribute = input.querySelector('input[name*="[experience_title]"]').getAttribute('name');
                const match = nameAttribute.match(/\[(\d+)\]/);
                if (match) {
                    const index = parseInt(match[1]);
                    if (index > maxIndex) {
                        maxIndex = index;
                    }
                }
            });
            return maxIndex + 1;
        }

        // Logika untuk menambahkan input Experience baru
        function addExperienceInput() {
            const container = document.getElementById('experiences-container');
            const newIndex = getNextExperienceIndex();
            const newDiv = document.createElement('div');
            newDiv.className = 'experience-input p-4 border border-indigo-200 bg-indigo-50 rounded-lg space-y-3 relative';
            
            newDiv.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <input type="text" name="experiences[${newIndex}][experience_title]" placeholder="Judul Pengalaman" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                    <input type="text" name="experiences[${newIndex}][organization_name]" placeholder="Organisasi" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Mulai</label>
                        <input type="date" name="experiences[${newIndex}][start_date]" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Selesai (atau Sekarang)</label>
                        <input type="date" name="experiences[${newIndex}][end_date]" class="w-full border-gray-300 rounded-lg p-2.5 text-sm">
                    </div>
                </div>
                <textarea name="experiences[${newIndex}][description]" placeholder="Deskripsi atau pencapaian (Opsional)" rows="3" class="w-full border-gray-300 rounded-lg p-2.5 text-sm"></textarea>
                <button type="button" onclick="removeExperienceInput(this)" class="absolute top-2 right-2 text-red-500 hover:text-red-700 p-1 rounded-full transition duration-150 ease-in-out">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            `;
            container.appendChild(newDiv);
        }

        // Logika untuk menghapus input Experience
        function removeExperienceInput(buttonElement) {
            buttonElement.closest('.experience-input').remove();
            // PENTING: Setelah menghapus, kita harus memastikan index name input berurutan lagi
            reindexExperienceInputs();
        }

        // Fungsi untuk memastikan array experiences memiliki index berurutan setelah penghapusan
        function reindexExperienceInputs() {
            const container = document.getElementById('experiences-container');
            const inputs = container.querySelectorAll('.experience-input');
            
            inputs.forEach((input, index) => {
                input.querySelectorAll('input, textarea').forEach(field => {
                    const originalName = field.getAttribute('name');
                    // Ganti index lama dengan index baru
                    const newName = originalName.replace(/experiences\[\d+\]/g, `experiences[${index}]`);
                    field.setAttribute('name', newName);
                });
            });
        }
    </script>
</body>
</html>