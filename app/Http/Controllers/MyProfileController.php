<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Client;
use App\Models\Photographer;

class MyProfileController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        $profilePhoto = $this->getProfilePhoto($user);
        return view('myprofile', compact('user', 'profilePhoto'));
    }

    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        $photoPath = $request->file('profile_photo')->store('profile_photos', 'public');

        if ($user->account_type === 'client') {
            $clientInfo = Client::where('account_id', $user->id)->first();
            if ($clientInfo && $clientInfo->profile_photo) {
                Storage::disk('public')->delete($clientInfo->profile_photo);
            }
            $clientInfo->profile_photo = $photoPath;
            $clientInfo->save();
        } elseif ($user->account_type === 'photographer') {
            $photographerInfo = Photographer::where('account_id', $user->id)->first();
            if ($photographerInfo && $photographerInfo->profile_photo) {
                Storage::disk('public')->delete($photographerInfo->profile_photo);
            }
            $photographerInfo->profile_photo = $photoPath;
            $photographerInfo->save();
        }

        return redirect()->route('myprofile')->with('success', 'Profile photo updated successfully.');
    }

    private function getProfilePhoto($user)
    {
        if ($user->account_type === 'client') {
            $clientInfo = Client::where('account_id', $user->id)->first();
            return $clientInfo ? $clientInfo->profile_photo : null;
        } elseif ($user->account_type === 'photographer') {
            $photographerInfo = Photographer::where('account_id', $user->id)->first();
            return $photographerInfo ? $photographerInfo->profile_photo : null;
        }
        return null;
    }

    public function updateProfile(Request $request)
{
    $user = auth()->user();
    $photographerInfo = Photographer::where('account_id', $user->id);
    $skills = $request->input('skills', []);

    $skills = array_slice($skills, 0, 3);

    $photographerInfo->update([
        'started_working' => $request->input('started_working'),
        'about' => $request->input('about'),
        'rating' => $request->input('rating'),
        'skill1' => isset($skills[0]) ? $skills[0] : null,
        'skill2' => isset($skills[1]) ? $skills[1] : null,
        'skill3' => isset($skills[2]) ? $skills[2] : null,
        'number_of_jobs' => $request->input('number_of_jobs'),
    ]);

    return redirect()->back()->with('success', 'Profile updated successfully!');
}

}
