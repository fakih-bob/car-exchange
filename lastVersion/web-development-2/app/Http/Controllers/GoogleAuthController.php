<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Client;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

   public function callback()
{
    $googleUser = Socialite::driver('google')->stateless()->user();

    $existingUser = User::where('email', $googleUser->getEmail())->first();

    if ($existingUser) {
        if ($existingUser->role !== 'client') {
            return redirect('/login')->with('error', 'Google login is only allowed for client accounts.');
        }

        Auth::login($existingUser);
    } else {
        // Create only client role
        $user = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'is_verified' => 1,
            'role' => 'client',
        ]);

        Client::create(['user_id' => $user->id]); // Link to client table
        Auth::login($user);
    }

    return redirect('/dashboard'); // or wherever you want
}
}
