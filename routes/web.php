<?php

use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/







Route::redirect('/', '/login');


Auth::routes(['verify' => true]);

Route::get('login/github', 'Auth\LoginController@redirectToProvider');
Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');

Route::group(['middleware' => 'verified','auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('users', 'UsersController')->middleware('checkRole');
    Route::view('/notifications','notifications.index')->name('notifications.show');
    Route::resource('chats', 'ChatsController')->except('show');
    Route::get('/chats/{toUser}', 'ChatsController@show')->name('chats.show');
    Route::get('testsendmail', function () {
        dispatch(new SendEmailJob);
    });
}); 


