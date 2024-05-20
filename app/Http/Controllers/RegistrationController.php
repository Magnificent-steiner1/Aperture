<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Client;
use App\Models\Photographer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client as GuzzleClient;

class RegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        $user = Auth::user();
        if($user){
            return redirect('/');
        }
        return view('registration');
    }

    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:accounts',
                'password' => 'required|string|min:8|confirmed',
                'dob' => 'required|date|before_or_equal:18 years ago',
                'address' => 'required|string',
                'account_type' => 'required|string|in:photographer,client',
            ], $this->customMessages());

            // Geocode the address
            $coordinates = $this->geocodeAddress($validatedData['address']);

            $account = new Account();
            $account->name = $validatedData['name'];
            $account->email = $validatedData['email'];
            $account->password = Hash::make($validatedData['password']);
            $account->dob = $validatedData['dob'];
            $account->address = $validatedData['address'];
            $account->latitude = $coordinates['latitude'];
            $account->longitude = $coordinates['longitude'];
            $account->account_type = $validatedData['account_type'];

            $account->save();
            $this->createRelatedInfo($account);

            return redirect()->route('login')->with('success', 'Registration successful. You can now log in.');
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->errors());
        } 
        catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    private function customMessages()
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The email address has already been taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'dob.required' => 'The date of birth field is required.',
            'dob.date' => 'Please enter a valid date for the date of birth.',
            'dob.before_or_equal' => 'You must be at least 18 years old to register.',
            'address.required' => 'The address field is required.',
            'account_type.required' => 'The account type field is required.',
            'account_type.in' => 'Please select a valid account type.',
        ];
    }

    private function geocodeAddress($address)
    {
        $latitude = null;
        $longitude = null;

        try {
            $client = new GuzzleClient();
            $response = $client->get('https://api.openrouteservice.org/geocode/search', [
                'query' => [
                    'api_key' => '5b3ce3597851110001cf62488841a5709d9346f18d99f104a92a1768', // Replace with your actual API key
                    'text' => $address,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if (!empty($data['features'])) {
                $coordinates = $data['features'][0]['geometry']['coordinates'];
                $latitude = $coordinates[1];
                $longitude = $coordinates[0];
            } else {
                return compact('latitude', 'longitude');
            }
        } catch (\Exception $e) {
            return compact('latitude', 'longitude');
        }

        return compact('latitude', 'longitude');
    }

    private function createRelatedInfo(Account $account)
    {
        try {
            if ($account->account_type === 'client') {
                Client::create([
                    'account_id' => $account->id,
                    'profile_photo' => null,
                ]);
            } elseif ($account->account_type === 'photographer') {
                Photographer::create([
                    'account_id' => $account->id,
                    'profile_photo' => null,
                    'started_working' => null,
                    'about' => null,
                    'rating' => 0,
                    'skill1' => null,
                    'skill2' => null,
                    'skill3' => null,
                    'number_of_jobs' => 0,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error creating related info for account ID ' . $account->id . ': ' . $e->getMessage());
            throw $e; 
        }
    }
}
