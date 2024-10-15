<?php

use App\Http\Controllers\api\AfterauthApiController;
use App\Http\Controllers\api\BeforeauthApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/test', function () {
//     return response()->json(['message' => 'API is working']);
// });

Route::group(['prefix' => 'beforeauth', 'as' => 'api.', 'namespace' => 'api'], function () {
    
    Route::post('/Register', [BeforeauthApiController::class, 'Register'])->name('Register');
    Route::post('/Login', [BeforeauthApiController::class, 'Login'])->name('Login');

});


    
Route::group(['prefix' => 'afterauth', 'as' => 'afterauth','middleware' => ['jwt.auth']], function () {

    Route::post('/getUserDetails', [AfterAuthApiController::class, 'getUserDetails'])->name('getUserDetails');
    Route::post('/Logout', [AfterAuthApiController::class, 'Logout'])->name('Logout');
    Route::post('/Refresh', [AfterAuthApiController::class, 'Refresh'])->name('Refresh');
    Route::post('/Support', [AfterAuthApiController::class, 'Support'])->name('Support');

});


