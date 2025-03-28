<?php

namespace App\Contracts\Services;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

interface AuthServiceContract
{
    public function registerUser(RegisterRequest $request):bool;
    public function verifyUserEmail($id, $hash):bool;

    public function logoutUser(Request $request):bool;

    public function sendVerificationEmail(Request $request):bool;
}
