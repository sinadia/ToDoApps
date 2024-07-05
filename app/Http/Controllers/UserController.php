<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    public function login(){
        return view('user.login');
    }

    public function loginAuth(Request $request){
        // Validasi input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Coba dapatkan pengguna berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Jika pengguna ditemukan dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Buat session atau token autentikasi
            Auth::login($user);
            return redirect('dashboard');
        }

        return redirect('/user/login')->with('error', 'Login gagal. Silakan coba lagi.');
    }

    public function register(){
        return view('user.register');
    }

    public function storeRegister(Request $request){
        $value = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            // 'password' => Hash::make($request->password),
            'group' => 'user',
        ];

        // dd($value);

        User::create($value);
        return redirect('dashboard');
    }

    public function profile(){
        return view('user.profile');
    }

    public function updateProfile(Request $request){
    $user = Auth::user();

    // Validation Rules (Customizable)
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required', 'string', 'email', 'max:255', 
            Rule::unique('users')->ignore($user->id) // Unique except for this user
        ],
        'current_password' => 'nullable|required_with:new_password|current_password', // Required only if new password is provided
        'new_password' => 'nullable|string|min:8|confirmed', // 'confirmed' rule ensures the confirmation matches
    ]);

    // Update Profile Information
    $user->name = $request->name;
    $user->email = $request->email;

    // Check if Password Change is Requested
    if ($request->filled('new_password')) {
        $user->password = Hash::make($request->new_password); 
    }

    $user->save(); // Save changes

    // Redirect with Success Message
    return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }

    public function userList()
    {
        // Check Authorization (Middleware or Gate)
        //$this->authorize('viewAny', User::class); // Using Laravel's authorization policies

        // Fetch Users (Paginated for Better Performance)
        $users = User::paginate(15); // Show 15 users per page

        // Error Handling (Optional)
        if ($users->isEmpty()) {
            return back()->with('error', 'No users found.'); // Redirect back with error message
        }

        // Return the View
        return view('user.userList', compact('users'));  // Pass the users to the view
    }


    
    public function logout(){
        Auth::logout();
        return view('user.login');
    }
}
