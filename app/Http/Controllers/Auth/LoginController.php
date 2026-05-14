<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    // Форма авторизации
    public function loginForm(): View
    {
        return view('auth.login');
    }

    // Авторизация
    public function login(LoginRequest $request): RedirectResponse
    {
        $cleanPhone = preg_replace('/\D+/', '', $request->phone);

        $user = Auth::attempt([
            'phone' => $cleanPhone,
            'password' => $request->password,
        ]);

        if (!$user) {
            return redirect()->back()->withErrors(['auth' => 'Неверный логин или пароль.']);
        }

        return redirect()->intended(route('home'));
    }

    // Выход
    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect()->back(fallback: route('home'));
    }
}
