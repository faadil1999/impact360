<?php

namespace App\Http\Controllers\Auth;

use App\Enum\Space;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\OrganizationType;
use Illuminate\Validation\Rules;
use App\Enum\OrganizationTypeEnum;
use App\Enum\OrganizationStatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        $organizationTypes = OrganizationType::query()->with('subTypes')->get();

        /** For getting only needed role space for organization */
        $filteredSpaces = array_filter(Space::cases(), function ($case) {
            return in_array($case, [Space::OrganizationActor, Space::OrganizationContributror]);
        });
        $filteredUserSpaces = array_filter(Space::cases(), function ($case) {
            return in_array($case, [Space::Beneficiary, Space::Contributor]);
        });

        $userRoles = array_map(fn($case) => $case->value, $filteredUserSpaces);
        $organizationRoles = array_map(fn($case) => $case->value, $filteredSpaces);

        return Inertia::render('Auth/Register', ['organizationTypes' => $organizationTypes, 'organizationRoles' => $organizationRoles, 'userRoles' => $userRoles]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'is_founder' => 'boolean',
            'organization.founder.first_name' => 'required_if:is_founder,true|string|max:255',
            'organization.founder.last_name' => 'required_if:is_founder,true|string|max:255',
            'organization.founder.phone' => 'required_if:is_founder,true|string|max:255',
            'organization.founder.email' => 'required_if:is_founder,true|string|lowercase|email|max:255',
            'organization.founder.password' => ['required_if:is_founder,true', 'confirmed', Rules\Password::defaults()],

            'organization.creation.name' => ['required_if:is_founder,true', 'string', 'max:255'],
            'organization.creation.type_organization_id' => ['required_if:is_founder,true', 'integer'],
            'organization.creation.sub_type_organization_id' => ['required_if:is_founder,true', 'integer'],
            'organization.creation.organization_role' => ['required_if:is_founder,true', 'array']
        ]);
        dd($validated);

        if ($validated['is_founder']) {

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
                'status' => OrganizationStatusEnum::PENDING,
                'organization_type_id' => $validated['organization']['creation']['type_organization_id'],
                'organization_sub_type_id' => $validated['organization']['creation']['sub_type_organization_id']
            ]);

            $user->assignRole('founder');
            foreach ($role as $validated['organization']['creation']['organization_role']) {
                $organization->assignRole($role);
            }
        }

        if ($validated['is_beneficary']) {
            $user->assignRole('beneficiary');
        }


        /**TODO::Look for organization registration code */
        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
