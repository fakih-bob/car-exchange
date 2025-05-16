<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Driver;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class userController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                "status" => false,
                "message" => "Invalid email or password"
            ]);
        }

        // Only block unverified clients
        if (!$user->is_verified && $user->role === 'client') {
            if (!$user->otp || $user->otp_expires_at < now()) {
                $otp = rand(100000, 999999);
                $user->otp = $otp;
                $user->otp_expires_at = now()->addMinutes(10);
                $user->save();

                Mail::raw("Your new OTP is: $otp", function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject('Your New OTP - Email Verification');
                });
            }

            return response()->json([
                "status" => false,
                "not_verified" => true,
                "message" => "Client email not verified. A new OTP has been sent."
            ]);
        }

        // ✅ Verified user → allow login
        Auth::login($user);
        $token = $user->createToken("Authtoken")->plainTextToken;

        return response()->json([
            "token" => $token,
            "status" => true,
            "message" => "Login successful",
            "user_id" => auth()->id(),
            "role" => $user->role
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:client,admin,driver'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = bcrypt($request->password);
        $user->save();

        if ($user->role === 'client') {
            // Create related client model
            Client::create(['user_id' => $user->id]);

            // Generate OTP
            $otp = rand(100000, 999999);
            $user->otp = $otp;
            $user->otp_expires_at = Carbon::now()->addMinutes(10);
            $user->save();

            // Send email
            Mail::raw("Your OTP is: $otp", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Verify Your Email - OTP');
            });

            return response()->json([
                "status" => true,
                "message" => "Client registered. OTP sent for email verification.",
                "data" => $user
            ]);
        } else {
           

            if ($user->role === 'driver') {
                Driver::create(['user_id' => $user->id]);
            }

            $token = $user->createToken("Authtoken")->plainTextToken;

            return response()->json([
                "status" => true,
                "token" => $token,
                "message" => "User registered successfully",
                "data" => $user
            ]);
        }
    }

    public function showVerifyForm(Request $request)
    {
        $email = $request->query('email');
        $user = User::where('email', $email)->first();

        if (!$user || $user->role !== 'client') {
            return redirect('/auth')->with('error', 'Only clients can verify by OTP.');
        }

        return view('verify', ['email' => $email]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6'
        ]);

        $user = User::where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->first();

        if (!$user || $user->otp_expires_at < now()) {
            return back()->with('error', 'Invalid or expired OTP.');
        }

        $user->is_verified = true;
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        return redirect('/dashboard')->with('success', 'Email verified. You can now login.');
    }
}
