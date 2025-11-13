<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lunaris</title>
    <link rel="icon" href="{{ asset('assets/images/app-logo.png') }}">
    @vite('resources/css/app.css')
</head>
<body>
    @include('components.header')

    <h1 class="font-bold text-2xl mb-4">Cari pekerjaan apa?</h1>
    <form action="" method="GET">
        <input type="text" name="keyword" placeholder="Masukkan kata kunci lowongan..." value="{{ $search ?? '' }}">
        <button type="submit">Cari</button>
    </form>
    
    <div>
        <button>Lokasi</button>
        <button>Tipe Kerja</button>
        <button>FnB</button>
    </div>

    <main style="display: flex;">
        <section style="flex: 1;">
            {{-- <h2>Daftar Lowongan ({{ count($jobs) }} ditemukan)</h2> --}}
            
            {{-- @forelse ($jobs as $job)
                <div style="border: 1px solid #ccc; margin-bottom: 10px; padding: 10px;">
                    <a href="">
                        <p><strong>{{ $job->title }}</strong></p>
                        <p>{{ $job->company->name }}</p>
                        <p>{{ $job->location }} ({{ $job->work_type }})</p>
                    </a>
                </div>
            @empty
                <p>Tidak ada pekerjaan yang ditemukan.</p>
            @endforelse --}}
        </section>

        <aside style="flex: 2; border-left: 1px solid #000; padding-left: 20px;">
            {{-- @if ($selectedJob)
                <h2>{{ $selectedJob->title }}</h2>
                <p><strong>{{ $selectedJob->company->name }}</strong></p>
                <p>{{ $selectedJob->location }} ({{ $selectedJob->work_type }})</p>
                <hr>
                
                <h3>Job Description:</h3>
                <pre>{{ $selectedJob->description }}</pre>

                <h3>Requirements:</h3>
                <pre>{{ $selectedJob->requirements }}</pre>

                <button>Apply</button>
                <button>Chat</button>
            @else
                <p>Pilih pekerjaan dari daftar di sebelah kiri untuk melihat detail.</p>
            @endif --}}
        </aside>
    </main>

    </body>
</html>