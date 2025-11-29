<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangeApplicationVisibilityController extends Controller
{
    public function toggleStatus(Request $request, Job $job)
    {
        if (Auth::user()->company->id !== $job->company_id) { 
            abort(403, 'Anda tidak diizinkan mengubah status lowongan ini.');
        }

        $request->validate([
            'is_active' => 'required|boolean',
        ]);
        
        $newStatus = $request->input('is_active');
        $oldTitle = $job->title;

        try {
            $job->update([
                'is_active' => $newStatus,
            ]);

            $message = $newStatus 
                       ? "Lowongan '{$oldTitle}' berhasil diaktifkan."
                       : "Lowongan '{$oldTitle}' berhasil dinonaktifkan.";

            return redirect()
                ->back()
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal mengubah status lowongan: ' . $e->getMessage());
        }
    }
}
