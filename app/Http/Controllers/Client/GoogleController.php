<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            [
                'google_user_id' => $googleUser->id
            ],
            [
                'name' => $googleUser->name, 
                'email' => $googleUser->email,
                'password' => Hash::make('password@Password!'),
                'google_user_id' => $googleUser->id
            ]
        );
        
        Auth::login($user);

        return redirect(route('admin.product_category.index', absolute: false));
    }
}
