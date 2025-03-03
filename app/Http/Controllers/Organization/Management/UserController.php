<?php

namespace App\Http\Controllers\Organization\Management;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Function for showing all user
     *
     * @return Redirect
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->has('search'), fn($q) => $q->search(['last_name', 'first_name', 'email']))
            ->paginate(15)
            ->appends($request->query());

        $responseData = [
            'users' => $users,
            'filters' => [
                'search' => $request->get('search', '')
            ]
        ];
        return Inertia::render('Founder/User/Index', $responseData);
    }

    /**
     * Function for storing user
     *
     * @return Response
     */
    public function store() {}

    public function edit() {}


    /**
     * Function for updating user
     *
     * @return Response
     *
     */
    public function update() {}
}
