<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Services\TenantService;
use App\Tenant\Events\TenantCreated;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }



    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $validator = Validator::make($request->all(), [ // funciona
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'cnpj' => ['required', 'string', 'unique:tenants'],
            'empresa' => ['required','string', 'unique:tenants,name']
        ]);

        if ($validator->fails()) {  // não retorna 
           
            return redirect('register')
                    ->withErrors($validator);

        }

        // Recebe os dados do formulário
        $data = $request->all();

        if(!$plan = session('plan')){
            return redirect()->route('site.home');
        }

        
        $tenantService = app(TenantService::class);

        $user = $tenantService->make($plan, $data);

        event(new Registered($user));
        event(new TenantCreated($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
    
}


