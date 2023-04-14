<?php

namespace App\Http\Controllers\Authcontroller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Authcontroller\Basecontroller as Basecontroller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class Authentication extends Basecontroller
{
    use HasApiTokens;
    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required |unique:users',
                'email' => 'required|unique:users',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return $this->senderror('please validate error', $validator->errors());
            }
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);
            $success['token'] = $user->createToken('ahmadghazal')->plainTextToken;
            $success['name'] = $user->name;
            DB::commit();
            return $this->sendresponse($success, 'user register successfly');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->senderror('please validate error', $validator->errors());
        }
    }
    public function login(Request $request, User $user)
    {   
        $request->validate([
            'email' => 'required',
            'password' => 'required|string'
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return $this->senderror('Unauthorized', ['error', 'Unauthorized']);
        }
        $users = $request->user();
        $success['token'] =  $users->createToken('ahmadghazal')->plainTextToken;
        $success['name'] = $users->name;
        return $this->sendresponse($success, 'user login successfly');
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->sendresponse(['message' => 'user logout successfly'], 200);
    }
    public function delete(Request $request)
    {
        $request->user()->delete();
        return $this->sendresponse(['message' => 'user delete successfly'], 200);
    }
    public function logadmin()
    {
        return "found";
    }
}
