<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Laravel\Passport\Token;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:55',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);
        $accessToken = $user->createToken('UserToken')->accessToken;
        return response()->json([
            'user' => new UserResource($user),
            'token' => $accessToken,
            'token_type' => 'Bearer'
        ]);
    }
    public function login(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }
        if (!auth()->attempt($data)) {
            return response()->json('Email or password is incorrect.', 422);
        }
        $user = auth()->user();
        $tokenResult = $user->createToken('userToken');
        $tokenModel = $tokenResult->token;
        if ($request->remember_me)
            $tokenModel->expires_at = Carbon::now()->addWeeks(1);
        $tokenModel->save();
        return response()->json([
            'user' => new UserResource($user),
            'token' => $tokenResult->accessToken,
            'token_type' => 'Bearer'
        ]);
    }
    public function logout(Request $request)
    {
        /** @var User $user
         */
        $request->user()->token()->revoke();
        return response()->json('You have successfully logged out.');
    }

    public function gettokenexpires(){
        $token = Token::where('user_id', 1)->first();
        $expiresIn = Carbon::parse($token->expires_at)->diffInSeconds(Carbon::now());

        return response()->json($expiresIn);
    }
    public function getuserid(){
        $user = Auth::user();
        $userId = $user->id;
        return response()->json($userId);
    }
    public function getuser(){
        $user = Auth::user();

        return response()->json(new UserResource($user));
    }

    public function updateuser(Request $request){
        $user = Auth::user();
        $data = $request->all();

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->address = $data['address'];
        $user->number = $data['number'];

        $user->save();

        return response()->json(['ok']);



    }
}
