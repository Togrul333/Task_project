<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $data = $request->validated();
        $token = $this->generateToken();

        $user= User::create([
            'username'=>$data['username'],

            // it is not a good way to storing sensitive data like apikey or password in db without any encryption
            // but the main focus on calculation of distance
            'apikey'=> $token
        ]);

        return [
            'user' => $user,
            'token' => $token
        ];
    }
    public function generateToken() :string {
        return bin2hex(random_bytes(62));
    }
}
