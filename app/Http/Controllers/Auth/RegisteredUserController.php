<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
            'role'        => ['required', 'in:tenant,guard'],
            'phone'       => ['required_if:role,tenant', 'nullable', 'string', 'max:20'],
            'national_id' => ['required_if:role,tenant', 'nullable', 'string', 'max:50'],
            'gender'      => ['required_if:role,tenant', 'nullable', 'in:male,female,other'],
        ]);

        $isGuard = $request->role === 'guard';
        $status  = $isGuard ? User::STATUS_PENDING : User::STATUS_ACTIVE;

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status'   => $status,
        ]);

        // Create a Tenant profile immediately so the dashboard never crashes on null
        if (!$isGuard) {
            Tenant::create([
                'user_id'     => $user->id,
                'phone'       => $request->phone,
                'national_id' => $request->national_id,
                'gender'      => $request->gender,
            ]);
        }

        event(new Registered($user));

        // Auto-sign in ALL newly registered users
        Auth::login($user);

        // Guard lands on pending-approval page; tenant goes straight to dashboard
        if ($isGuard) {
            return redirect()->route('auth.pending');
        }

        return redirect()->route('tenant.dashboard');
    }
}
