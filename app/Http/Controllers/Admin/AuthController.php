<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        if ($request->session()->get('cms_authenticated')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $validEmail = hash_equals(config('cms.admin_email'), $credentials['email']);
        $validPassword = hash_equals(config('cms.admin_password'), $credentials['password']);

        if (! $validEmail || ! $validPassword) {
            return back()
                ->withErrors(['email' => 'Email atau password admin tidak sesuai.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();
        $request->session()->put('cms_authenticated', true);

        return redirect()->route('admin.dashboard')->with('status', 'Berhasil masuk ke CMS.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('cms_authenticated');
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'Berhasil keluar dari CMS.');
    }
}
