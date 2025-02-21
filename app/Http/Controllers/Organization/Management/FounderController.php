<?php

namespace App\Http\Controllers\Organization\Management;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Enum\OrganizationStatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Organization\UserAsFounderFormRequest;

class FounderController extends Controller
{
    /**
     * Function for dashboard home page
     *
     * @return Redirection
     *
     */
    public function index()
    {
        return Inertia::render('Founder/Home');
    }

    /**
     * Function for registering founder
     *
     * @return Redirection
     *
     */
    public function store(UserAsFounderFormRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'first_name' => $validated['organization']['founder']['first_name'],
            'last_name' => $validated['organization']['founder']['last_name'],
            'phone' => $validated['organization']['founder']['phone'],
            'email' => $validated['organization']['founder']['email'],
            'password' => Hash::make($validated['organization']['founder']['password']),
        ]);
        $organization = Organization::create([
            'name' => $validated['organization']['creation']['name'],
            'user_id' => $user->id,
            'organization_type_id' => $validated['organization']['creation']['type_organization_id'],
            'organization_sub_type_id' => $validated['organization']['creation']['sub_type_organization_id']
        ]);

        $user->assignRole('founder');
        foreach ($validated['organization']['creation']['organization_role'] as $role) {
            $organization->assignRole($role);
        }
        event(new Registered($user));

        Auth::login($user);
        return redirect(route('founder.dashboard'));
    }
}
