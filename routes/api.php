// routes/api.php

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
// 🔽 追加
use App\Http\Controllers\Api\TweetController;
// 🔽 追加
use App\Http\Controllers\Api\TweetLikeController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

// 🔽 追加
Route::middleware('auth:sanctum')->group(function () {
  Route::apiResource('tweets', TweetController::class);
 // 🔽 2 行追加
 Route::post('/tweets/{tweet}/like', [TweetLikeController::class, 'store']);
 Route::delete('/tweets/{tweet}/like', [TweetLikeController::class, 'destroy']);
});


