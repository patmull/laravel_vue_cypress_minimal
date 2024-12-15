<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AdminEmailController extends Controller {
    /**
     * Show the confirm password view.
     * @throws ValidationException
     */
    public function check(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !$user->is_admin) {
            $status = 'Nejste oprávnění pro tuto operaci.
            Zkontrolujte, zda e-mail souhlasí s administrátorským emailem.';
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return response()->json(['success' => true]);
    }
}
