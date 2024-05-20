<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Photographer;
use App\Models\Client;
use App\Models\Account;

use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $photographer = Photographer::where('account_id', $user->id)->first();
        
        $offers = Job::where('photographer_id', $photographer->photographer_id)
            ->where('status', null)
            ->with('client') // Eager load the client
            ->get();
            
        return view('offers', compact('offers'));
    }

    public function acceptOffer()
    {
        $user = Auth::user();
        $photographer = Photographer::where('account_id', $user->id)->first();

        $offer = Job::where('photographer_id', $photographer->photographer_id)
            ->where('status', null)
            ->first();
        
        if ($offer) {
            $offer->status = 'accepted';
            $offer->save();

            // Ignore other offers on the same date
            Job::where('photographer_id', $photographer->photographer_id)
                ->where('date', $offer->date)
                ->where('status', null)
                ->update(['status' => 'ignored']);

            return redirect()->route('offers.index')->with('success', 'Offer accepted successfully!');
        } else {
            return redirect()->route('offers.index')->with('error', 'No offer available to accept.');
        }
    }

    public function ignoreOffer()
    {
        $user = Auth::user();
        $photographer = Photographer::where('account_id', $user->id)->first();

        $offer = Job::where('photographer_id', $photographer->photographer_id)
            ->where('status', null)
            ->first();
        
        if ($offer) {
            $offer->status = 'ignored';
            $offer->save();
            return redirect()->route('offers.index')->with('success', 'Offer ignored successfully!');
        } else {
            return redirect()->route('offers.index')->with('error', 'No offer available to ignore.');
        }
    }
}
