<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use App\Models\Photographer;
use App\Models\Client;

class ActiveContractsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $contracts = collect();
        $userType = '';

        // Check if the user is a photographer
        if ($photographerInfo = Photographer::where('account_id', $user->id)->first()) {
            $userType = 'photographer';
            // Fetch jobs with status 'accepted' for the authenticated photographer
            $contracts = Job::where('photographer_id', $photographerInfo->photographer_id)
                ->where('status', 'accepted')
                ->get();
        }

        // Check if the user is a client
        if ($clientInfo = Client::where('account_id', $user->id)->first()) {
            $userType = 'client';
            // Fetch jobs with status 'accepted' for the authenticated client
            $contracts = Job::where('client_id', $clientInfo->client_id)
                ->where('status', 'accepted')
                ->get();
        }

        // If user is neither a photographer nor a client, redirect with an error message
        if ($userType == '') {
            return redirect()->route('home')->with('error', 'You do not have access to active contracts.');
        }

        return view('active-contracts', compact('contracts', 'userType'));
    }

    public function cancel(Request $request)
    {
        $user = Auth::user();

        $photographerInfo = Photographer::where('account_id', $user->id)->first();

        $job = Job::where('job_id', $request->job_id)
            ->where('photographer_id', $photographerInfo->photographer_id)
            ->where('status', 'accepted')
            ->first();

        if ($job) {
            $job->status = 'cancelled';
            $job->save();

            return redirect()->route('active-contracts.index')->with('success', 'Contract cancelled successfully!');
        }

        return redirect()->route('active-contracts.index')->with('error', 'Failed to cancel contract.');
    }

    public function end(Request $request)
    {
        $user = Auth::user();

        $clientInfo = Client::where('account_id', $user->id)->first();

        $job = Job::where('job_id', $request->job_id)
            ->where('client_id', $clientInfo->client_id)
            ->where('status', 'accepted')
            ->first();

        if ($job) {
            $job->status = 'ended';
            $job->save();

            return redirect()->route('active-contracts.index')->with('success', 'Contract ended successfully!');
        }

        return redirect()->route('active-contracts.index')->with('error', 'Failed to end contract.');
    }
}

