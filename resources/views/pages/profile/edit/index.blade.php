<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil</title>
    @vite('resources/css/app.css')
</head>
<body>
    <h1>Edit Profil</h1>
    
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <section style="border: 1px solid black; padding: 15px; margin-bottom: 20px;">
            <h2>Informasi Dasar</h2>

            <div>
                <label for="full_name">Nama Lengkap</label>
                <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $profile->full_name) }}">
            </div>
            
            <div>
                <label for="city">Kota</label>
                <input type="text" id="city" name="city" value="{{ old('city', $profile->city) }}">
            </div>
            
            <div>
                <label for="country">Negara</label>
                <input type="text" id="country" name="country" value="{{ old('country', $profile->country) }}">
            </div>

            <div>
                <label for="biography">Biografi</label>
                <textarea id="biography" name="biography">{{ old('biography', $profile->biography) }}</textarea>
            </div>
        </section>

        <section style="border: 1px solid black; padding: 15px; margin-bottom: 20px;">
            <h2>Foto Profil & Background</h2>
            
            <div>
                <label for="profile_photo">Foto Profil</label>
                <input type="file" id="profile_photo" name="profile_photo">
                @if($profile->profile_photo_path)
                    <p>Foto saat ini: <img src="{{ asset('storage/' . $profile->profile_photo_path) }}" width="50"></p>
                @endif
            </div>

            <div>
                <label for="background_photo">Background Profil</label>
                <input type="file" id="background_photo" name="background_photo">
                @if($profile->background_photo_path)
                    <p>Background saat ini: <img src="{{ asset('storage/' . $profile->background_photo_path) }}" width="100"></p>
                @endif
            </div>
        </section>

        <section style="border: 1px solid black; padding: 15px; margin-bottom: 20px;">
            <h2>Skills</h2>
            <div id="skills-container">
                @forelse($profile->skills as $index => $skill)
                    <div class="skill-input">
                        <input type="text" name="skills[]" value="{{ old('skills.'.$index, $skill->name) }}" placeholder="Nama Skill">
                    </div>
                @empty
                    <div class="skill-input">
                        <input type="text" name="skills[]" placeholder="Nama Skill">
                    </div>
                @endforelse
            </div>
            <button type="button" onclick="addSkillInput()">Tambah Skill</button>
        </section>

        <section style="border: 1px solid black; padding: 15px; margin-bottom: 20px;">
            <h2>Edukasi</h2>
            <div id="educations-container">
                 @forelse($profile->educations as $index => $education)
                    <div class="education-input" style="border: 1px dashed #ccc; padding: 10px; margin-top: 5px;">
                        <input type="text" name="educations[{{ $index }}][institution_name]" placeholder="Institusi" value="{{ old('educations.'.$index.'.institution_name', $education->institution_name) }}"><br>
                        <input type="text" name="educations[{{ $index }}][degree]" placeholder="Gelar" value="{{ old('educations.'.$index.'.degree', $education->degree) }}"><br>
                        <input type="date" name="educations[{{ $index }}][start_date]" value="{{ old('educations.'.$index.'.start_date', $education->start_date) }}"><br>
                        <input type="date" name="educations[{{ $index }}][end_date]" value="{{ old('educations.'.$index.'.end_date', $education->end_date) }}" placeholder="Tanggal Selesai"><br>
                        <textarea name="educations[{{ $index }}][description]" placeholder="Deskripsi">{{ old('educations.'.$index.'.description', $education->description) }}</textarea>
                    </div>
                @empty
                    <div class="education-input" style="border: 1px dashed #ccc; padding: 10px; margin-top: 5px;">
                        <input type="text" name="educations[0][institution_name]" placeholder="Institusi"><br>
                        <input type="text" name="educations[0][degree]" placeholder="Gelar"><br>
                        <input type="date" name="educations[0][start_date]"><br>
                        <input type="date" name="educations[0][end_date]" placeholder="Tanggal Selesai"><br>
                        <textarea name="educations[0][description]" placeholder="Deskripsi"></textarea>
                    </div>
                @endforelse
            </div>
            <button type="button" onclick="addEducationInput()">Tambah Edukasi</button>
        </section>


        <button type="submit" style="padding: 10px; background-color: green; color: white;">Simpan Profil</button>
    </form>

    <script>
        // Logika untuk menambahkan input Skill baru
        function addSkillInput() {
            const container = document.getElementById('skills-container');
            const newIndex = container.children.length;
            const newDiv = document.createElement('div');
            newDiv.className = 'skill-input';
            newDiv.innerHTML = `<input type="text" name="skills[]" placeholder="Nama Skill Baru"> <button type="button" onclick="this.parentNode.remove()">Hapus</button>`;
            container.appendChild(newDiv);
        }

        // Logika untuk menambahkan input Education baru
        function addEducationInput() {
            const container = document.getElementById('educations-container');
            const newIndex = container.children.length; // Gunakan index baru
            const newDiv = document.createElement('div');
            newDiv.className = 'education-input';
            newDiv.style.cssText = "border: 1px dashed #ccc; padding: 10px; margin-top: 5px;";
            
            newDiv.innerHTML = `
                <input type="text" name="educations[${newIndex}][institution_name]" placeholder="Institusi"><br>
                <input type="text" name="educations[${newIndex}][degree]" placeholder="Gelar"><br>
                <input type="date" name="educations[${newIndex}][start_date]"><br>
                <input type="date" name="educations[${newIndex}][end_date]" placeholder="Tanggal Selesai"><br>
                <textarea name="educations[${newIndex}][description]" placeholder="Deskripsi"></textarea>
                <button type="button" onclick="this.parentNode.remove()">Hapus Edukasi</button>
            `;
            container.appendChild(newDiv);
        }
    </script>
</body>
</html>