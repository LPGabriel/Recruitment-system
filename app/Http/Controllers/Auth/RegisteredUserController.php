<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('authentications.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tipoConta' => ['required'],
            'phone' => ['required'],
            'terms' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required'],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user_data = [
            'type' => $request->tipoConta,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ];
        
        $user = User::create($user_data);

        if ($request->tipoConta == 'company') {
            $company_data = [
                'name_company' => $request->name_company,
                'cpnj' => $request->cnpj,
            ];

            $company = new Company($company_data);

            $user->company()->save($company);
        }

        if ($request['type'] == 'candidate') {
            $user->assignRole('candidate');
        }

        $stripeCustomer = $user->createAsStripeCustomer();

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
