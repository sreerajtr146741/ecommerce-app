<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\AuthenticationException;
use Exception;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email|max:255',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);

            return redirect()
                ->route('products.index')
                ->with('success', 'Welcome! Your account has been created successfully.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            \Log::error('Registration failed: ' . $e->getMessage());

            return back()
                ->with('error', 'Something went wrong. Please try again later.')
                ->withInput($request->only('name', 'email'));
        }
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email'    => 'required|email',
                'password' => 'required|string',
            ]);

            $remember = $request->filled('remember');

            if (Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate();

                return redirect()
                    ->intended(route('products.index'))
                    ->with('success', 'Welcome back!');
            }

            return back()
                ->withErrors(['email' => 'The provided credentials are incorrect.'])
                ->onlyInput('email');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            \Log::error('Login failed: ' . $e->getMessage());

            return back()
                ->with('error', 'An error occurred. Please try again.')
                ->withInput($request->only('email'));
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with('success', 'You have been logged out.');

        } catch (Exception $e) {
            \Log::error('Logout failed: ' . $e->getMessage());

            return redirect('/login')->with('error', 'Logout failed. Please try again.');
        }
    }
}