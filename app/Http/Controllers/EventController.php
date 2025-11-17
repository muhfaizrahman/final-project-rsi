<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // Index & Search
    public function index(Request $request)
    {
        $search = $request->get('search');

        $events = Event::query()
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%')
                             ->orWhere('location', 'like', '%' . $search . '%')
                             ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->orderBy('event_datetime', 'asc')
            ->paginate(6);

        return view('pages.event.index', compact('events', 'search'));
    }

    public function indexDetail(Event $event) {
        $isRegistered = Auth::check() ? $event->isRegisteredBy(Auth::user()) : false;

        $relatedEvents = Event::where('id', '!=', $event->id)
                          ->inRandomOrder()
                          ->limit(3)
                          ->get();

        return view('pages.event.detail.index', compact('event', 'isRegistered', 'relatedEvents'));
    }

    // Menampilkan Form Registrasi
    public function createRegistration(Event $event)
    {
        
        // Cek apakah user sudah terdaftar
        if ($event->isRegisteredBy(Auth::user())) {
             return redirect()->route('eventPage')->with('warning', 'Anda sudah terdaftar untuk event ini.');
        }
        
        // Data default form (dari data user yang sedang login)
        $user = Auth::user();

        return view('pages.event.register.index', compact('event', 'user'));
    }

    // 3. Memproses Pendaftaran
    public function storeRegistration(Request $request, Event $event)
    {
        // Validasi
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|max:255',
        ]);

        $user = Auth::user();
        
        // Cek unik (redundansi, walaupun sudah ada unique constraint di DB)
        if ($event->isRegisteredBy($user)) {
             return redirect()->route('eventPage')->with('warning', 'Anda sudah terdaftar untuk event ini.');
        }

        try {
            // Simpan pendaftaran
            EventRegistration::create([
                'event_id' => $event->id,
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
            ]);

            return redirect()->route('eventPage')
                             ->with('success', "Pendaftaran event '{$event->title}' berhasil!");

        } catch (\Exception $e) {
            // Jika ada error (misal Unique Constraint di DB)
            return back()->withInput()
                         ->withErrors(['registration' => 'Gagal melakukan pendaftaran. Silakan coba lagi.']);
        }
    }
}
