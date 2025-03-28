<?php

namespace App\Services;

use App\Contracts\Services\AuthServiceContract;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthService implements AuthServiceContract
{
    public function registerUser(RegisterRequest $request): bool
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $user = User::create($data);

            auth()->login($user);

            event(new Registered($user));

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return false;
        }
    }

    public function verifyUserEmail($id, $hash): bool
    {
        try {
            $user = User::findOrFail($id);

            if (!hash_equals((string)$hash, sha1($user->getEmailForVerification()))) {
                abort(403, 'Не верная ссылка подтверждения.');
            }

            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();

                Auth::login($user);

                return true;
            }

            return false;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return false;
        }
    }

    public function logoutUser(Request $request): bool
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return true;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return false;
        }
    }

    public function sendVerificationEmail(Request $request): bool
    {
        try {
            $user = $request->user();

            if (!$user) {
                return false; // Пользователь не аутентифицирован
            }

            if ($user->hasVerifiedEmail()) {
                return true; // Email уже подтвержден
            }

            $user->sendEmailVerificationNotification();

            return 'Email отправлен';
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return false;
        }
    }
}
