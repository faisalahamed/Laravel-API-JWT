<?php

use App\Http\Controllers\Api\CourseApiController;
use App\Http\Controllers\Api\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("register", [UserAuthController::class, "register"]);
Route::post("login", [UserAuthController::class, "login"]);

Route::group(["middleware" => ["auth:api"]], function(){

    Route::get("profile", [UserAuthController::class, "profile"]);
    Route::get("logout", [UserAuthController::class, "logout"]);

    // course api routes
    Route::post("course-enrol", [CourseApiController::class, "courseEnrollment"]);
    Route::get("total-courses", [CourseApiController::class, "totalCourses"]);
    Route::get("delete-course/{id}", [CourseApiController::class, "deleteCourse"]);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
