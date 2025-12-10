<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationConfirmationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //login form view
    public function showLoginForm()
    {
        // Redirect if already authenticated
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    //registration form view
    public function showRegisterForm()
    {
        // Redirect if already authenticated
        if (auth()->check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    //registreren van nieuwe user
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // User maken
        $fullName = trim($validated['first_name'] . ' ' . $validated['last_name']);
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'name' => $fullName ?: $validated['first_name'], // Fallback name
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // User automatisch inloggen
        auth()->login($user);

        $request->session()->regenerate();

        // Registratie bevestiging email versturen
        Mail::to($user->email)->send(new RegistrationConfirmationMail($user));

        // Winkelwagen cookie wissen (zelfde als inloggen)
        $cookie = Cookie::make('shopping_cart', '', -1, '/', null, null, false, false, 'lax');

        return redirect()->route('home')
            ->cookie($cookie)
            ->with('success', 'Account created successfully!');
    }

    //inloggen van user
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (auth()->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Winkelwagen cookie wissen (van wanneer user niet ingelogd was)
            // Winkelwagen database behouden (user's saved cart persists)
            $cookie = Cookie::make('shopping_cart', '', -1, '/', null, null, false, false, 'lax');

            return redirect()->intended(route('home'))
                ->cookie($cookie);
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    
    //uitloggen van user
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}

