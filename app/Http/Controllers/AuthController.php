<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;

class AuthController extends Controller
{
    /* ===========================
       SHOW REGISTER PAGE
    ============================ */
    public function showRegister()
    {
        return view('auth.register');
    }

    /* ===========================
       HANDLE REGISTRATION + RETURN TOKEN
    ============================ */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
            ]);

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // CREATE TOKEN (for API or future use)
            $token = $user->createToken('mystore-app-token')->plainTextToken;

            // FOR WEB: Just redirect to login
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Registered successfully',
                    'user'    => $user,
                    'token'   => $token
                ], 201);
            }

            return redirect()->route('login')
                             ->with('success', 'Account created! Please login.')
                             ->withCookie(cookie('api_token', $token, 60*24*30)); // optional

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            \Log::error('Registration Error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong');
        }
    }

    /* ===========================
       SHOW LOGIN PAGE
    ============================ */
    public function showLogin()
    {
        return view('auth.login');
    }

    /* ===========================
       HANDLE LOGIN + RETURN TOKEN
    ============================ */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email'    => 'required|email',
                'password' => 'required|string',
            ]);

            if (Auth::attempt($credentials, $request->filled('remember'))) {
                $user = Auth::user();
                $request->session()->regenerate();

                // CREATE TOKEN FOR THIS LOGIN
                $token = $user->createToken('mystore-app-token')->plainTextToken;

                // FOR API RESPONSE
                if ($request->wantsJson() || $request->is('api/*')) {
                    return response()->json([
                        'message' => 'Login successful',
                        'user'    => $user,
                        'token'   => $token
                    ]);
                }

                return redirect()->route('products.index')
                                 ->with('success', 'Welcome back, ' . $user->name . '!')
                                 ->withCookie(cookie('api_token', $token, 60*24*30));

            }

            return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');

        } catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            \Log::error('Login Error: ' . $e->getMessage());
            return back()->with('error', 'Login failed');
        }
    }

    /* ===========================
       LOGOUT + REVOKE ALL TOKENS
    ============================ */
    public function logout(Request $request)
    {
        try {
            $user = Auth::user();

            if ($user) {
                // Revoke all tokens (super secure)
                $user->tokens()->delete();
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Clear token cookie
            return redirect('/login')
                           ->with('success', 'Logged out successfully!')
                           ->withCookie(\Cookie::forget('api_token'));

        } catch (Exception $e) {
            \Log::error('Logout Error: ' . $e->getMessage());
            return redirect('/login');
        }
    }
}