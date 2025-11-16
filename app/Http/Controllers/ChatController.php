<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Message;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index() {
        $threads = Thread::where('user_id', Auth::id())
                        ->with(['job', 'company', 'messages'])
                        ->orderByDesc('updated_at')
                        ->get();

        // Ambil ID thread pertama (jika ada) untuk ditampilkan detailnya secara default
        $selectedThread = $threads->first();
        $messages = $selectedThread ? $selectedThread->messages()->latest()->get()->reverse() : collect();

        return view('pages.chat.index', compact('threads', 'selectedThread', 'messages'));
    }

    // Fungsi untuk menampilkan detail chat (messages)
    public function show(Thread $thread) {
        // Pastikan pelamar yang login adalah pemilik thread
        if ($thread->user_id !== Auth::id()) {
            return redirect()->route('chatsPage')->with('error', 'Akses ditolak.');
        }

        $threads = Thread::where('user_id', Auth::id())
                        ->with(['job', 'company'])
                        ->orderByDesc('updated_at')
                        ->get();
                        
        $messages = $thread->messages()->latest()->get()->reverse(); // Ambil pesan dan urutkan dari lama ke baru
        
        return view('pages.chat.index', [
            'threads' => $threads,
            'selectedThread' => $thread,
            'messages' => $messages,
        ]);
    }
    
    // Fungsi untuk membuat thread (jika belum ada) dan redirect ke chat
    public function createOrShow(Job $job) {
        $user = Auth::user();
        
        // Cek apakah thread sudah ada
        $thread = Thread::where('user_id', $user->id)
                        ->where('job_id', $job->id)
                        ->first();
        
        if (!$thread) {
            // Jika belum ada, buat thread baru
            $thread = Thread::create([
                'user_id' => $user->id,
                'job_id' => $job->id,
                'company_id' => $job->company_id, 
            ]);
            
            // Opsi: Tambahkan pesan inisiasi/sambutan otomatis jika perlu
        }
        
        return redirect()->route('showDetailChat', $thread);
    }

    public function sendMessage(Request $request, Thread $thread) {
        $request->validate(['content' => 'required|string|max:1000']);

        // Pastikan pelamar yang login adalah pemilik thread
        if ($thread->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak diizinkan mengirim pesan ke thread ini.');
        }
        
        Message::create([
            'thread_id' => $thread->id,
            'sender_id' => Auth::id(),
            'content' => $request->input('content'),
            'sender_type' => 'applicant',
        ]);

        return back();
    }
}
