<?php

use App\Http\Controllers\DashboardController;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return redirect()->route('user.dashboard');
});

Route::get('/email/verify/{id}/{hash}', function (Request $request) {
    $user = User::findOrFail($request->route('id'));

    if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
        throw new AuthorizationException;
    }

    if ($user->hasVerifiedEmail()) {
        return redirect(config('fortify.home'));
    }

    DB::beginTransaction();

    try {
        $user->markEmailAsVerified();
        Event::dispatch(new Verified($user));
        DB::commit();

        return redirect(config('fortify.home'))->with('verified', true);
    } catch (\Exception $e) {
        DB::rollback();
        $user->email_verified_at = null;
        $user->save();

        return redirect('/email/verify')->with('error', 'Onboarding failed: ' . $e->getMessage());
    }
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::middleware(['auth', 'verified'])->prefix('user')->group(function () {
    Route::get("/dashboard", [DashboardController::class,"index"])->name("user.dashboard");

    Route::get("/demo", [DashboardController::class, "demo"])->name("user.demo");
});