<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register1');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $data['password'] = Hash::make($data['password']);

            User::query()->create($data);

            return redirect()
                ->route('login1')
                ->with('success', true);
        } catch (\Throwable $th) {
            return back()
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    public function showLoginForm()
    {
        return view('auth.login1');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|string|min:8',
        ]);

        try {
            if (Auth::attempt($credentials)) {
                return redirect()
                    ->intended('/dashboard')
                    ->with('success', true);
            }

            return back()
                ->with('success', false)
                ->withErrors(['email' => 'Thông tin đăng nhập không chính xác.']);
        } catch (\Throwable $th) {
            return back()
                ->with('success', false)
                ->with('error', $th->getMessage());
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login1');
    }
}
