<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Giriş formunu göster
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Giriş işlemini gerçekleştir
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'E-posta adresi gereklidir.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'password.required' => 'Şifre gereklidir.',
        ]);

        // if (Auth::attempt($credentials, $request->boolean('remember'))) {
        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();

            // Eğer redirect_to varsa, o adresi göster
            if ($request->get('redirect_to')) {
                return redirect()->to($request->get('redirect_to'));
            }

            // Kullanıcının rolüne göre yönlendirme
            /** @var User $user */
            $user = Auth::user();
            if ($user->hasRole(\App\Enums\UserRole::SUPERADMIN) || $user->hasRole(\App\Enums\UserRole::ADMIN) || $user->hasRole(\App\Enums\UserRole::ESTATE_AGENCY)) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->route('app.account.index');

            return redirect()->intended(route('website.home'));
        }

        throw ValidationException::withMessages([
            'email' => ['Girdiğiniz bilgiler hatalı.'],
        ]);
    }

    /**
     * Kayıt formunu göster
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Kayıt işlemini gerçekleştir
     */
    public function register(Request $request)
    {
        $request->validate([
            // 'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ], [
            'name.required' => 'Ad Soyad gereklidir.',
            'name.max' => 'Ad Soyad en fazla 255 karakter olabilir.',
            'email.required' => 'E-posta adresi gereklidir.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique' => 'Bu e-posta adresi zaten kayıtlı.',
            'password.required' => 'Şifre gereklidir.',
            'password.confirmed' => 'Şifre tekrarı eşleşmiyor.',
        ]);

        $firstPartOfEmail = explode('@',$request->email)[0];

        $user = User::create([
            'name' => $request->name ?? $firstPartOfEmail,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user, true);

        if ($request->get('redirect_to')) {
            return redirect()->to($request->get('redirect_to'));
        }

        return redirect()->route('website.home');
    }

    /**
     * Şifremi unuttum formunu göster
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Şifre sıfırlama e-postası gönder
     */
    public function sendResetEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'E-posta adresi gereklidir.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
        ]);

        // Laravel'in built-in şifre sıfırlama sistemi
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Şifre sıfırlama bağlantısı e-posta adresinize gönderildi.');
        }

        return back()->withErrors(['email' => 'Bu e-posta adresi ile kayıtlı kullanıcı bulunamadı.']);
    }

    /**
     * Şifre sıfırlama formunu göster
     */
    public function showResetForm(Request $request, $token = null)
    {
        $validate = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'E-posta adresi gereklidir.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
        ]);

        if ($validate->fails()) {
            return redirect()->route('auth.forgot-password')->withErrors($validate);
        }

        return view('auth.reset-password')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Şifre sıfırlama işlemini gerçekleştir
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ], [
            'email.required' => 'E-posta adresi gereklidir.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'password.required' => 'Şifre gereklidir.',
            'password.confirmed' => 'Şifre tekrarı eşleşmiyor.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('auth.login')->with('success', 'Şifreniz başarıyla sıfırlandı. Yeni şifrenizle giriş yapabilirsiniz.');
        }

        return back()->withErrors(['email' => 'Şifre sıfırlama bağlantısı geçersiz veya süresi dolmuş.']);
    }

    /**
     * Çıkış işlemini gerçekleştir
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
} 