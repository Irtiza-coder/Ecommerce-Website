<?php

namespace App\Http\Controllers;

use App\Models\Signup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function signup(Request $request)
    {
        $request->validateWithBag('signup', [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:signups,email',
            'password' => 'required|string|same:password_confirm',
        ]);

        $signup = new Signup();

        $signup->First_name = $request->first_name;
        $signup->Last_name = $request->last_name;
        $signup->email = $request->email;
        $signup->password = Hash::make($request->password);

        $signup->save();

        return redirect('/account')
            ->with('message', 'Account created! Please log in.')
            ->with('form', 'signup');
    }


    public function login(Request $request)
    {
        $request->validateWithBag('login', [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = Signup::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            session([
                'user_id' => $user->id,
                'user_name' => $user->First_name
            ]);
            if (!empty(session('cart'))) {
                return redirect()->route('checkout')->with('message', 'Welcome back! You can now complete your order.');
            }

            return redirect('/dashboard')
                ->with('message', 'Logged in successfully!')
                ->with('form', 'login');
        }

        return back()
            ->with('error', 'Invalid email or password.')
            ->with('form', 'login');
    }

    public function showProfile()
    {
        $user = Signup::find(session('user_id'));
        if (!$user) {
            return redirect('/account')->with('error', 'Please log in to view your profile.');
        }
        return view('profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Signup::find(session('user_id'));

        if (!$user) {
            return redirect('/account')->with('error', 'Please log in to update your account.');
        }

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:signups,email,' . $user->id,
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6|same:new_password_confirmation',
        ]);

        $user->First_name = $request->first_name;
        $user->Last_name = $request->last_name;
        $user->email = $request->email;

        // If changing password
        if ($request->filled('new_password')) {
            if (!$request->filled('current_password')) {
                return back()->with('error', 'Please enter your current password to set a new password.');
            }

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Current password does not match our records.');
            }

            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        session(['user_name' => $user->First_name]);

        return back()->with('message', 'Your profile and password have been updated successfully!');
    }
}