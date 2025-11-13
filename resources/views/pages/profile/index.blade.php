<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="icon" href="{{ asset('assets/images/app-logo.png') }}">
    @vite('resources/css/app.css')
    <style>
        /* Gaya kustom tambahan untuk gradasi header */
        .header-bg {
            background: linear-gradient(135deg, #a8dadb 0%, #457b9d 100%);
        }
    </style>
</head>
<body class="bg-gray-100 ">

    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        
        {{-- Background Photo --}}
        <div class="header-bg rounded-lg shadow-xl h-48 sm:h-64 relative overflow-hidden">
            <img src="" alt="Header Background" class="absolute inset-0 w-full h-full object-cover opacity-70">
            {{-- <div class="absolute inset-0 bg-black opacity-10"></div> --}}
            

            <div class="absolute top-1/2 transform -translate-y-1/2 left-8 sm:left-16 flex items-center">
                {{-- Profile Photo --}}
                <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-full border-4 border-white shadow-lg overflow-hidden">
                    <img src="{{ asset('assets/images/profile-picture.jpg') }}" alt="Profile Photo" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        <div class="px-4 sm:px-0">
            <div class="flex items-center mb-8 space-x-3">
                <div class="flex flex-col">
                    <h1 class="text-4xl font-bold text-gray-900">{{ auth()->user()->profile->full_name }}</h1>
                    <p class="text-lg text-gray-600">City, Country</p>
                </div>
                <a class="text-white bg-[#7E794B] hover:bg-[#6B6840] px-5 py-2 rounded-full" href="{{ route('editProfilePage') }}">Edit</a>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">

                    {{-- Short Bio --}}
                    <div class="bg-white p-6 rounded-lg shadow-md space-y-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">Short Bio</h2>
                            <p class="text-gray-700 leading-relaxed">
                                Saya seorang Digital Marketing Specialist yang berpengalaman di bidang strategi pemasaran digital dan media sosial. Memiliki pemahaman mendalam tentang siklus penuh proyek, mulai dari ideation, planning, hingga pelaksanaannya. Saya memiliki kemampuan analisis data dan SEO yang mendukung pengambilan keputusan berbasis insight. Senang bekerja dalam tim yang dinamis, memiliki visi jangka panjang, serta bekerja tanpa pengawasan terus-menerus. Berkomitmen untuk terus belajar, berinovasi, dan memberikan kontribusi nyata bagi pertumbuhan perusahaan.
                            </p>
                        </div>

                        {{-- Skills --}}
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">Skills</h2>
                            {{-- Skill Item --}}
                            <div class="flex flex-wrap gap-3">
                                <span class="bg-gray-100 text-black text-sm font-medium p-2 rounded-xl shadow-md">UI/UX Designer</span>
                            </div>
                        </div>
                    </div>


                    {{-- Experience --}}
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Experience</h2>
                        
                        <div class="mb-6 p-4 border-l-4 border-blue-500 bg-blue-50/50 rounded-r-md">
                            {{-- Experience Item --}}
                            <div class="flex items-center mb-2">
                                <span class="text-blue-500 mr-3 text-2xl">🏢</span>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">Digital Marketing Executive - PT Kreatif Media</h3>
                                    <p class="text-sm text-gray-500">(2022 - Sekarang)</p>
                                </div>
                            </div>
                            <ul class="list-disc ml-6 text-gray-700 space-y-1">
                                <li>Merancang dan melaksanakan kampanye digital untuk meningkatkan *engagement* media sosial hingga **45%**.</li>
                                <li>Menganalisis performa konten menggunakan **Google Analytics** dan platform media sosial.</li>
                                <li>Mengembangkan strategi SEO yang efektif sehingga *traffic* meningkat **30%** dalam 6 bulan.</li>
                                <li>Berkolaborasi dengan tim desain dan produk untuk menghasilkan materi *marketing* yang kreatif dan relevan.</li>
                            </ul>
                        </div>

                        <div class="p-4 border-l-4 border-purple-500 bg-purple-50/50 rounded-r-md">
                            <div class="flex items-center mb-2">
                                <span class="text-purple-500 mr-3 text-2xl">🎉</span>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">Social Media Intern - Startup XYZ</h3>
                                    <p class="text-sm text-gray-500">(2021 - 2022)</p>
                                </div>
                            </div>
                            <ul class="list-disc ml-6 text-gray-700 space-y-1">
                                <li>Mengelola konten harian untuk platform TikTok dan LinkedIn.</li>
                                <li>Menyiapkan *database*, kalender, dan membantu strategi *influencer marketing*.</li>
                                <li>Melakukan riset pasar dan pesaing untuk mendukung pengambilan keputusan tim *marketing*.</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Education</h2>
                        <div class="p-4 border-l-4 border-green-500 bg-green-50/50 rounded-r-md">
                            <div class="flex items-center mb-2">
                                <span class="text-green-500 mr-3 text-2xl">🎓</span>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">University of Brawijaya</h3>
                                    <p class="text-sm text-gray-500">2021 - 2025</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Contact Person --}}
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white p-6 rounded-lg shadow-md sticky top-8">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Contact</h2>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <img src="https://via.placeholder.com/50/f0f8ff/457b9d?text=C1" alt="Email Logo" class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                                <div class="flex flex-col">
                                    <span class="text-gray-800 font-medium">Email</span>
                                    <span class="text-gray-800">blablabla@gmail.com</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <img src="https://via.placeholder.com/50/f0f8ff/457b9d?text=C2" alt="Phone Logo" class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                                <div class="flex flex-col">
                                    <span class="text-gray-800 font-medium">Phone</span>
                                    <span class="text-gray-800">+62 88983901283910</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</body>
</html>