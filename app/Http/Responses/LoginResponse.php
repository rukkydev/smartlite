<?php


namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
class LoginResponse implements LoginResponseContract

{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function toResponse($request)
    {
        $user = $request->user();

        // Normal login redirect
        return redirect()->intended(config('fortify.home'));
    }
}
