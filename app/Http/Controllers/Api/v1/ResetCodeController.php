<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\ResetCodePassword;
use App\Models\User;
use Illuminate\Http\Request;

class ResetCodeController extends Controller
{
    public function sendResetCode(Request $request)
    {
        $email = $request->input('email');

        // Generate a random reset code
        $code = substr(md5(mt_rand()), 0, 4);

        // Save the reset code to the database
        ResetCodePassword::create([
            'email' => $email,
            'code' => $code,

        ]);

        // Send the reset code to the user's email
        // Implement your own email sending logic here

        return response()->json(['message' => $code]);
    }



    public function checkResetCode(Request $request)
    {
        $email = $request->input('email');
        $code = $request->input('code');

        // Check if the reset code is valid
        $resetCode = ResetCodePassword::where('email', $email)
            ->where('code', $code)
            ->first();

        if ($resetCode) {
            return response()->json(['message' => 'Reset code is valid']);
        } else {
            return response()->json(['message' => 'Invalid reset code'], 400);
        }
    }

    public function resetPassword(Request $request)
    {
        $email = $request->input('email');
        $code = $request->input('code');
        $newPassword = $request->input('new_password');

        // Check if the reset code is valid
        $resetCode = ResetCodePassword::where('email', $email)
            ->where('code', $code)
            ->first();

        if (!$resetCode) {
            return response()->json(['message' => 'Invalid reset code'], 400);
        }

        // Update the user's password
        $user = User::where('email', $email)->first();

        $user->password = bcrypt($newPassword);
        $user->save();

        // Delete the reset code from the database
        $resetCode->delete();

        return response()->json(['message' => 'password changed']);
    }
}
