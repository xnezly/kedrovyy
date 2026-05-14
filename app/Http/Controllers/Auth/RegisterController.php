<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    // Форма регистрации
    public function registerForm(): View
    {
        return view('auth.register');
    }

    // Регистрация
    public function register(RegisterRequest $request): RedirectResponse
    {
        $cleanPhone = preg_replace('/\D+/', '', $request->phone);

        $user = User::create([
            'phone' => $cleanPhone,
            'name' => $request->name,
//            'age' => $request->age,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }
}
