<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    // fwVkfHrN9h07OkxISpYrncXNZqquCbbbRVNz2tk20e2f3c4f
    public function getUser()
    {
        return rescue(function () {
            return response()->json([
                'status' => true,
                'payload' => auth()->user(),
                '_time' => time()
            ], 500);
        }, function (\Exception $exception) {
            return response()->json([
                'status' => false,
                'payload' => [
                    'message' => $exception->getMessage()
                ],
                '_time' => time()
            ], 500);
        });
    }


    public function createUser(Request $request)
    {
        return rescue(function () use ($request) {

            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8'
            ]);

            return response()->json([
                'status' => true,
                'payload' => tap(\App\Models\User::create($request->all()),
                    function ($user) {
                        // create an api token
                        $user->token = $user
                            ->createToken('api-token')
                            ->plainTextToken;
                    }),
                '_time' => time()
            ], 200);

        }, function (\Exception $exception) {
            return response()->json([
                'status' => false,
                'payload' => [
                    'message' => $exception->getMessage()
                ],
                '_time' => time()
            ], 500);
        });
    }
}
