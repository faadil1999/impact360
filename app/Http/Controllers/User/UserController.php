<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\User\UserAsMemberFormRequest;

class UserController extends Controller
{
    /**
     * Function for home page
     *
     * @return \Inertia\Response
     *
     */
    public function index()
    {
        return Inertia::render('User/Home');
    }

    /**
     * Function for storing
     *
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function store(UserAsMemberFormRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'first_name' => $validated['register']['first_name'],
            'last_name' => $validated['register']['last_name'],
            'phone' => $validated['register']['phone'],
            'email' => $validated['register']['email'],
            'password' => Hash::make($validated['register']['password']),
        ]);

        $user->assignRole('member');
        foreach ($validated['register']['roles'] as $role) {
            $user->assignRole($role);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('member.dashboard'));
    }
}
