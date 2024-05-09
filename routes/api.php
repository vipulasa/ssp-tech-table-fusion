<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})
//    ->middleware('auth:sanctum');


Route::get('/hello', function (){
    return response()->json([
        'name' => 'Laravel',
        'greeting' => 'Hello, Laravel!',
        'array' => [1, 2, 3, 4, 5, 6]
    ]);
});

Route::get('/test-error', function () {

    return rescue(function(){
        // this is where you write the code !!

        throw new \Exception('This is an exception');

    }, function(\Exception $exception){
        // this is where you capture the errors !!!

        return response()->json([
            'status' => false,
            'payload' => [
                'message' => $exception->getMessage()
            ],
            '_time' => time()
        ], 500);
    });

    try {

        throw new \Exception('This is an exception');

    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ]);
    }
});

Route::get('/payload', function () {

    return response()->json([
        'status' => true,
        'payload' => [
            'name' => 'Laravel',
            'greeting' => 'Hello, Laravel!',
            'array' => [1, 2, 3, 4, 5, 6]
        ],
        '_time' => time()
    ]);


});

Route::get('/user', [
    \App\Http\Controllers\Api\UserAuthController::class,
    'getUser'
])->middleware('auth:sanctum');

Route::post('/user', [
    \App\Http\Controllers\Api\UserAuthController::class,
    'createUser'
]);
