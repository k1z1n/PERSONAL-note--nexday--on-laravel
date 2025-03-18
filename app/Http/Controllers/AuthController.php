<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        // Создаем пользователя
        $data = $request->validated();
        $user = User::create($data);

        // Логиним пользователя, чтобы маршрут подтверждения, защищённый middleware auth, мог работать
        Auth::login($user);

        // Отправка письма с подтверждением email
        event(new Registered($user));

        return redirect()->route('verification.notice')->with('message', 'Письмо с подтверждением отправлено!');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Регенерация сессии для безопасности
            $request->session()->regenerate();

            // Если email не подтверждён, перенаправляем на страницу подтверждения.
            // Пользователь остаётся авторизованным, чтобы иметь доступ к маршруту verification.notice (который защищён middleware auth).
            if (! Auth::user()->hasVerifiedEmail()) {
                return redirect()->route('verification.notice')
                    ->with('message', 'Пожалуйста, подтвердите ваш email.');
            }

            return redirect()->intended(route('view.home'))
                ->with('message', 'Вы успешно вошли в систему!');
        }

        // Если аутентификация не удалась, возвращаем ошибку
        return back()->withErrors([
            'email' => 'Неверный email или пароль.',
        ]);
    }

    public function verify(Request $request, $id, $hash)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Ссылка просрочена или недействительна.');
        }

        $user = User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Неверная ссылка подтверждения.');
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();

            // Авторизуем пользователя сразу после подтверждения
            Auth::login($user);

            return redirect('/')->with('message', 'Ваш email подтвержден!');
        }

        return redirect('/login')->with('message', 'Ваш email уже подтвержден.');
    }

    public function sendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('view.home');
        }

        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Письмо с подтверждением отправлено!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('view.home')->with('message', 'Вы успешно вышли из аккаунта.');
    }

    public function showEmailVerify(){
        return view('auth.verify-email');
    }
}
