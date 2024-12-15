<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Http\Controllers\Controller;

class UserPermissionController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getPermissions()
    {
        $user = auth()->user();
        return $user->getPermissionNames();
    }
}
