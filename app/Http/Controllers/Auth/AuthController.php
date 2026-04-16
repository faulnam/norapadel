<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && !$user->is_active) {
            return back()->with('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi admin.');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (auth()->user()->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            if (auth()->user()->isCourier()) {
                return redirect()->intended(route('courier.dashboard'));
            }

            return redirect()->intended(route('home'));
        }

        return back()->with('error', 'Email atau password salah.');
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        return $this->requestRegisterOtp($request);
    }

    /**
     * Request OTP for registration
     */
    public function requestRegisterOtp(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $defaultMailer = config('mail.default');
        if (in_array($defaultMailer, ['log', 'array'], true)) {
            return response()->json([
                'message' => 'Layanan email belum aktif. Silakan konfigurasi Gmail SMTP terlebih dahulu.',
            ], 422);
        }

        $otpCode = (string) random_int(100000, 999999);
        $cacheKey = $this->registrationOtpCacheKey($validated['email']);
        $ttlMinutes = 10;

        Cache::put($cacheKey, [
            'otp_hash' => Hash::make($otpCode),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'password' => Hash::make($validated['password']),
            'attempts' => 0,
        ], now()->addMinutes($ttlMinutes));

        try {
            Mail::raw(
                "Kode OTP registrasi NoraPadel Anda adalah: {$otpCode}\n\nKode berlaku {$ttlMinutes} menit. Jangan bagikan kode ini ke siapa pun.",
                function ($message) use ($validated) {
                    $message->to($validated['email'])
                        ->subject('Kode OTP Registrasi NoraPadel');
                }
            );
        } catch (\Throwable $exception) {
            Cache::forget($cacheKey);

            Log::error('Gagal mengirim OTP registrasi via SMTP.', [
                'email' => $validated['email'],
                'mailer' => config('mail.default'),
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'username' => config('mail.mailers.smtp.username'),
                'scheme' => config('mail.mailers.smtp.scheme'),
                'error' => $exception->getMessage(),
            ]);

            $message = 'Gagal mengirim OTP ke email. Periksa konfigurasi SMTP Gmail Anda.';

            $errorText = strtolower($exception->getMessage());

            if (str_contains($errorText, '535') || str_contains($errorText, 'username and password not accepted')) {
                $message = 'Autentikasi Gmail gagal. Gunakan App Password 16 digit (bukan password login Gmail biasa).';
            } elseif (str_contains($errorText, 'connection could not be established') || str_contains($errorText, 'timed out')) {
                $message = 'Koneksi ke server Gmail gagal. Periksa koneksi internet atau firewall.';
            } elseif (str_contains($errorText, 'expected response code') && str_contains($errorText, '530')) {
                $message = 'SMTP menolak request. Pastikan akun Gmail mengizinkan App Password dan 2-Step Verification aktif.';
            }

            return response()->json([
                'message' => $message,
            ], 500);
        }

        return response()->json([
            'message' => 'Kode OTP sudah dikirim ke email Anda.',
            'email' => $validated['email'],
            'ttl_minutes' => $ttlMinutes,
        ]);
    }

    /**
     * Verify OTP and complete registration
     */
    public function verifyRegisterOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus 6 digit.',
        ]);

        $cacheKey = $this->registrationOtpCacheKey($validated['email']);
        $otpData = Cache::get($cacheKey);

        if (!$otpData) {
            return response()->json([
                'message' => 'Kode OTP tidak ditemukan atau sudah kadaluarsa. Silakan daftar ulang.',
            ], 422);
        }

        if (($otpData['attempts'] ?? 0) >= 5) {
            Cache::forget($cacheKey);

            return response()->json([
                'message' => 'Terlalu banyak percobaan OTP. Silakan daftar ulang.',
            ], 429);
        }

        if (!Hash::check($validated['otp'], $otpData['otp_hash'])) {
            $otpData['attempts'] = ($otpData['attempts'] ?? 0) + 1;
            Cache::put($cacheKey, $otpData, now()->addMinutes(10));

            return response()->json([
                'message' => 'Kode OTP tidak valid.',
            ], 422);
        }

        if (User::where('email', $validated['email'])->exists()) {
            Cache::forget($cacheKey);

            return response()->json([
                'message' => 'Email sudah terdaftar. Silakan login.',
            ], 422);
        }

        $user = User::create([
            'name' => $otpData['name'],
            'email' => $otpData['email'],
            'phone' => $otpData['phone'],
            'address' => $otpData['address'],
            'password' => $otpData['password'],
            'role' => 'customer',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        Cache::forget($cacheKey);

        Auth::login($user);

        return response()->json([
            'message' => 'Registrasi berhasil! Akun Anda sudah aktif.',
            'redirect' => route('home'),
        ]);
    }

    private function registrationOtpCacheKey(string $email): string
    {
        return 'register_otp:' . sha1(strtolower($email));
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Anda telah logout.');
    }
}
