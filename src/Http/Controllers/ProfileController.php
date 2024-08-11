<?php

namespace Geekpack\Gauth\Http\Controllers;

use Geekpack\Gauth\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Event;
use Geekpack\Gauth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{

    public function showProfile()
    {
        return Inertia::render('Profile/Profile');
    }

}
