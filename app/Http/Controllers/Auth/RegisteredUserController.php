<?php

namespace App\Http\Controllers\Auth;

use App\Enum\OrganizationEnum;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'is_creating' => ['boolean'],
            'is_registering' => ['boolean'],
            'is_beneficary' => ['boolean'],
            'organization.creation.name' => ['required_if:is_creating,true', 'nullable', 'string', 'max:255'],
            'organization.registration.code' => ['required_if:is_registering,true', 'nullable', 'string', 'max:255']
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->is_beneficary) {
            $user->assignRole('beneficiary');
        }

        if ($request->is_creating) {
            Organization::create([
                'name' => $request->organization['creation']['name'],
                'status' => OrganizationEnum::PENDING,
                'user_id' => $user->id
            ]);
            $user->assignRole('founder');
        }
        /**TODO::Look for organization registration code */
        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
