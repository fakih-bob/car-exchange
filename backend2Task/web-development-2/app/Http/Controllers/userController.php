<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Client;
use App\Models\Driver;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

//use Auth;
class userController extends Controller
{


    public function login(Request $request)
    {
        $credentials = $request->only(["email", "password"]);
    
        $user = User::where('email', $credentials['email'])->first();
    
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                "status" => false,
                "message" => "Invalid email or password"
            ]);
        }
    
        logger()->info('User logged in: ' . $user->toJson());
    
        Auth::login($user); 
      //  $request->session()->regenerate();
        $token=$user->createToken("Authtoken")->plainTextToken;
        return response()->json([
            "token"=>$token,
            "status" => true,
            "message" => "User Logged in successfully",
            "user_id" => auth()->id(),
            "role" => $user->role
        ]);
    }
        
        
        public function register(Request $request) {
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
        
            $token = $user->createToken("Authtoken")->plainTextToken;
            if ($user->role == 'client') {
                Client::create(['user_id' => $user->id]);
            } elseif ($user->role == 'driver') {
                Driver::create(['user_id' => $user->id]);
            }
            return response()->json([
                "status" => true,
                "token" => $token,
                "data" => $user
            ]);
        }
}
