<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit() {
        $user = Auth::user();
        $profile = $user->profile()->with(['skills', 'educations'])->firstOrCreate(['user_id' => $user->id]);

        return view('pages.profile.edit.index', ['profile' => $profile]);
    }

    public function showProfilePage() {
        return view('pages.profile.index');
    }

    public function update(UpdateProfileRequest $request) {
        $user = Auth::user();
        $profile = $user->profile;

        // Upload file 
        $data = $request->validated();
        
        if ($request->hasFile('profile_photo_url')) {
            $data['profile_photo_url'] = $request->file('profile_photo_url')->store('profiles_photos', 'public');
        }

        if ($request->hasFile('background_photo_url')) {
            $data['background_photo_url'] = $request->file('background_photo_url')->store('background_photos', 'public');
        }

        // Transaksi database
        DB::transaction(function () use ($profile, $data, $request) {
            $profile->update([
                'full_name' => $data['full_name'] ?? null,
                'phone' => $data['phone'] ?? null,
                'city' => $data['city'] ?? null,
                'country' => $data['country'] ?? null,
                'biography' => $data['biography'] ?? null,
                'profile_photo_url' => $data['profile_photo_url'] ?? $profile->profile_photo_url,
                'background_photo_url' => $data['background_photo_url'] ?? $profile->background_photo_url,
            ]);

            // Update skills
            $profile->skills()->delete();
            $skillsToProcess = collect($request->skills)->filter();
            foreach ($skillsToProcess as $skillName) {
                if (!empty($skillName)) {
                    $profile->skills()->create(['name' => $skillName]);
                }
            }

            // Update educations
            $profile->educations()->delete();
            $educationsToProcess = collect($request->educations)->filter();
            foreach ($educationsToProcess as $edu) {
                if (!empty($edu['institution_name'])) {
                    $profile->educations()->create([
                        'institution_name' => $edu['institution_name'],
                        'degree' => $edu['degree'],
                        'city'=> $edu['city'],
                        'field_of_study' => $edu['field_of_study'],
                        'start_date' => $edu['start_date'] ?? null,
                        'end_date' => $edu['end_date'] ?? null,
                    ]);
                }
            }

            // Update experiences
            $profile->experiences()->delete();
            $experiencesToProcess = collect($request->experiences)->filter();
            foreach ($experiencesToProcess as $exp) {
                if (!empty($exp['experience_title'])) {
                    $profile->experiences()->create([
                        'experience_title' => $exp['experience_title'],
                        'organization_name' => $exp['organization_name'],
                        'start_date' => $exp['start_date'],
                        'end_date' => $exp['end_date'] ?? null,
                        'description' => $exp['description'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->route('profilePage')->with('success', 'Profil berhasil diperbarui!');
    }
}
