<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\Google2FA;
use App\Models\SiteSetting;
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

        // Check if 2FA is active
        $is2FaConfirmed = SiteSetting::where('key', 'two_factor_confirmed')->value('value') === '1';

        if ($is2FaConfirmed) {
            // Put login in pending state and redirect to 2FA verification page
            $request->session()->put('cms_auth_pending', true);
            return redirect()->route('admin.login.2fa');
        }

        $request->session()->regenerate();
        $request->session()->put('cms_authenticated', true);

        return redirect()->route('admin.dashboard')->with('status', 'Berhasil masuk ke CMS.');
    }

    public function show2fa(Request $request): View|RedirectResponse
    {
        if ($request->session()->get('cms_authenticated')) {
            return redirect()->route('admin.dashboard');
        }

        if (! $request->session()->get('cms_auth_pending')) {
            return redirect()->route('admin.login');
        }

        return view('admin.login-2fa');
    }

    public function verify2fa(Request $request): RedirectResponse
    {
        if (! $request->session()->get('cms_auth_pending')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $secret = SiteSetting::where('key', 'two_factor_secret')->value('value');

        if (! $secret || ! Google2FA::verifyCode($secret, $request->input('code'))) {
            return back()->withErrors(['code' => 'Kode OTP tidak valid atau sudah kedaluwarsa.']);
        }

        $request->session()->forget('cms_auth_pending');
        $request->session()->regenerate();
        $request->session()->put('cms_authenticated', true);

        return redirect()->route('admin.dashboard')->with('status', 'Berhasil masuk ke CMS.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget(['cms_authenticated', 'cms_auth_pending']);
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'Berhasil keluar dari CMS.');
    }
}
