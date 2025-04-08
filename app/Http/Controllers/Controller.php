<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function user($token)
    {
        $temporaryToken = \App\Models\TemporaryToken::where('token', $token)
            ->where('is_used', true)
            ->first();

        if (!$temporaryToken) {
            return null;
        }

        $user = User::find($temporaryToken->user_id);
        return $user;
    }
}
