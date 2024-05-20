<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photographer;
use App\Models\Client;
use App\Models\Account;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PhotographerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userLat = $user ? $user->latitude : null;
        $userLong = $user ? $user->longitude : null;

        $photographers = Photographer::join('accounts', 'photographer_info.account_id', '=', 'accounts.id')
            ->select('photographer_info.*', 'accounts.latitude', 'accounts.longitude', 'accounts.name')
            ->get()
            ->map(function ($photographer) use ($userLat, $userLong) {
                if ($userLat && $userLong) {
                    $photographer->distance = $this->calculateDistance($userLat, $userLong, $photographer->latitude, $photographer->longitude);
                } else {
                    $photographer->distance = 0;
                }
                return $photographer;
            });

            if ($user) {
                $clientInfo = Client::where('account_id', $user->id)->first();
    
                if ($clientInfo) {
                    Log::info('Client Info:', ['client_id' => $clientInfo->client_id]);
    
                    $pendingJobsQuery = Job::where('client_id', $clientInfo->client_id);
                    Log::info('Pending Jobs Query:', ['query' => $pendingJobsQuery->toSql(), 'bindings' => $pendingJobsQuery->getBindings()]);
    
                    $pendingJobs = $pendingJobsQuery->whereIn('status', [null, 'accepted'])
                        ->pluck('photographer_id')
                        ->toArray();
    
                    Log::info('Pending Jobs:', $pendingJobs);
                } else {
                    Log::info('No client information found for account ID:', [$user->id]);
                    $pendingJobs = [];
                }
            } else {
                Log::info('User not authenticated');
                $pendingJobs = [];
            }

        return view('photographers', compact('photographers', 'pendingJobs'));
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $kilometers = $miles * 1.609344;
        return round($kilometers, 2);
    }

    public function sendOffer(Request $request, $photographer_id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to send job offers.');
        }

        if ($user->account_type !== 'client') {
            return redirect()->back()->with('error', 'Only clients can send job offers.');
        }

        $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|after:today',
            'duration' => 'required|integer|min:1',
            'salary' => 'required|numeric|min:0',
        ]);

        $clientInfo = Client::where('account_id', $user->id)->first();
        if (!$clientInfo) {
            return redirect()->back()->with('error', 'Client information not found.');
        }

        Job::create([
            'client_id' => $clientInfo->client_id,
            'photographer_id' => $photographer_id,
            'type' => $request->input('type'),
            'description' => $request->input('description'),
            'date' => $request->input('date'),
            'duration' => $request->input('duration'),
            'salary' => $request->input('salary'),
            'status' => null,
        ]);

        return redirect()->back()->with('success', 'Offer sent successfully!');
    }
}
