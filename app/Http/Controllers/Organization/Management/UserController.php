<?php

namespace App\Http\Controllers\Organization\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Function for showing all user
     *
     * @return Redirect
     */
    public function index()
    {
        return Inertia::render('Founder/User/Index');
    }
}
