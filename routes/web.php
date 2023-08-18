<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(); // Génér automatiquement les routes nécessaires pour la gestion de l'authentification des utilisateurs

Route::get('/home', [HomeController::class, 'index'])->name('home'); 

Route::middleware('auth')->group(
    function () {
        Route::get('/user/show', [UserController::class, 'show'])->name('user.show');
        Route::get('/user/showAll', [UserController::class, 'showAll'])->name('user.showAll');

        Route::get('/user/form/update/nameEmail', [UserController::class, 'formUpdateNameEmail']);
        Route::get('/user/form/update/password', [UserController::class, 'formUpdatePassword']);
        Route::get('/user/form/update/photo', [UserController::class, 'formUpdatePhoto']);

        Route::post('/user/update/nameEmail', [UserController::class, 'updateNameEmail'])->name('user.update.nameEmail');
        Route::post('/user/update/password', [UserController::class, 'updatePassword'])->name('user.update.password');
        Route::post('/user/update/photo', [UserController::class, 'updatePhoto'])->name('user.update.photo');

        Route::get('/user/form/destroy/photo', [UserController::class, 'formDestroyPhoto']);
        Route::post('/user/destroy/photo', [UserController::class, 'destroyPhoto'])->name('user.destroy.photo');


        Route::get('/form/messages/send', [MessageController::class, 'formMessagesSend']);
        Route::post('/messages/send', [MessageController::class, 'sendMessage'])->name('send.message');
        Route::get('/messages/get', [MessageController::class, 'getMessages']);
    }
);
