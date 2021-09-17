<?php

use Illuminate\Support\Str;
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

Route::get('/', function () {
    return redirect("/login");
    // return view('welcome');
});

Route::get('/cache-clear', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    // Artisan::call('route:cache');
    // Artisan::call('route:clear');
    // Artisan::call('optimize');
    return 'Hello World';
});

Auth::routes();

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout_user');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/notice', 'NoticeController@index')->name('notice');

Route::get('/notice/add', 'NoticeController@add')->name('notice-add');
Route::post('/notice/add', 'NoticeController@save')->name('notice-save');

Route::get('/delete/{id}', 'NoticeController@delete')->name('delete');

Route::get('/deletetask/{id}', 'TaskController@deletetask')->name('deletetask');

Route::post('/response', 'ResponseController@index')->name('response');
Route::get('/pay/{package}', "PayController@index")->name('pay');
Route::get('/pay/subscribe', "PayController@create");
Route::get('/packages', 'PackageController@index')->name('packages');
Route::get('/affiliates', 'PackageController@refs')->name('refs');
Route::get('/package/add', 'PackageController@add')->name('addPackage');
Route::post('/package/add', 'PackageController@save');
Route::get('/packages/edit/{package}', 'PackageController@edit');
Route::post('/packages/{package}', 'PackageController@update');
Route::get('/packages/delete/{package}', "PackageController@destroy")->name('packages.destroy');
Route::get('/packages/subscribe/{package}', "PackageController@subscribe")->name('packages.subscribe');
Route::get('/packages/subscribe/', "PackageController@subscribe")->name('subscribe');
Route::get('/packages/unsubscribe/{package}', "PackageController@unSubscribe")->name('packages.unSubscribe');
Route::get('/package/send/{packageID}', "PackageController@sendTask")->name('packages.sendTask');
Route::get('/my-packages', "PackageController@myPackages")->name('packages.myPackages');

Route::get('/tasks/{pacakgeID?}', 'TaskController@index')->name('tasks');
Route::get('/task/add', 'TaskController@add')->name('addtask');
Route::post('/tasks/upload/sheet', 'TaskController@uploadSheet')->name('uploadSheet');
Route::post('/task/taskReply/{key}', 'TaskController@saveReply')->name('Reply.save');
Route::get('/task/taskReply/{taskID}', 'TaskController@addReply')->name('task.addreply'); 
Route::get('/task/showReply/{taskID}', 'TaskController@showReply')->name('task.showReply');
Route::post('/task/add', 'TaskController@save');
Route::get('/task/edit/{task}', 'TaskController@edit');
Route::get('/task/accept/{taskID}/{userID}/{packageID}/{id}', 'TaskController@accept');
Route::get('/task/reject/{taskID}/{userID}/{packageID}', 'TaskController@reject');
Route::get('/task/resubmit/{taskID}/{userID}/{packageID}', 'TaskController@resubmit');
Route::post('/task/acceptSelected', 'TaskController@acceptSelected')->name('acceptSelected');
Route::post('/task/rejectSelected', 'TaskController@rejectSelected')->name('rejectSelected');
Route::post('/task/{task}', 'TaskController@update');
Route::get('/task/delete/{task}', "TaskController@destroy")->name('tasks.destroy');

Route::get('/task/url/add', 'TaskController@addUrlTask')->name('addurltask');
Route::post('/task/url/add', 'TaskController@saveUrlTask')->name('saveurltask');
Route::post('/tasks/url/upload/sheet', 'TaskController@uploadUrlSheet')->name('uploadUrlSheet');
Route::get('/task/url/edit/{task}', 'TaskController@editUrl');
Route::post('/task/url/{task}', 'TaskController@updateUrl');
Route::get('/task/url/{taskID}', 'TaskController@visitUrl')->name('task.visitUrl');
Route::post('/task/url/{taskID}/complete', 'TaskController@UpdateTask')->name('task.updateTask');

Route::get('/tickets', 'TicketController@index')->name('tickets');
Route::get('/tickets/add', 'TicketController@add')->name('tickets-add');
Route::post('/tickets/add', 'TicketController@save')->name('tickets-save');
Route::get('/tickets/{ticketID}', 'TicketController@ticketDetail')->name('ticket-details');
Route::post('/tickets/{ticketID}/respond', 'TicketController@ticketReply')->name('respond-ticket');
Route::get('/tickets/{ticketID}/resolve', 'TicketController@resolveTicket')->name('resolve-ticket');

Route::get('/users', 'UsersController@users')->name('users');
Route::get('/users/create', 'UsersController@createForm')->name('createForm');
Route::post('/users/create', 'UsersController@create')->name('create');
Route::post('/users/upload/sheet', 'UsersController@uploadSheet')->name('uploadSheet');
Route::get('/users/edit/{id}', 'UsersController@edit')->name('edit');
Route::post('/users/update/{id}', 'UsersController@update')->name('update');

Route::get('/subscriptions', 'SubscriptionsController@subscriptions')->name('subscriptions');
Route::get('/subscriptions/new', 'SubscriptionsController@addSubscription')->name('subscriptions.add');
Route::post('/subscriptions/new', 'SubscriptionsController@saveSubscription')->name('subscriptions.save');
Route::get('/subscriptions/activate/{id?}', 'SubscriptionsController@activate')->name('subscriptions.activate');
Route::get('/subscriptions/deactivate/{id?}', 'SubscriptionsController@deactivate')->name('subscriptions.deactivate');
Route::get('/subscriptions/unsubscribe/{id?}', 'SubscriptionsController@unsubscribe')->name('subscriptions.unsubscribe');

Route::get('/payments/{id?}', 'PaymentsController@payments')->name('payments');

Route::get('/settings', 'SettingsController@settings')->name('settings');
Route::post('/settings/btc/update', 'SettingsController@btcDetailsUpdate')->name('btcDetailsUpdate');
Route::get('/withdrawls', 'WithdrawlsController@withdrawls')->name('withdrawls');
Route::post('/withdrawls/generate/request', 'WithdrawlsController@generate')->name('generate');
Route::get('/withdrawls/accept/{id}', 'WithdrawlsController@accept')->name('accept');
Route::get('/withdrawls/reject/{id}', 'WithdrawlsController@reject')->name('reject');
Route::post('/withdrawls/update', 'WithdrawlsController@update')->name('update');

// start coding for chat room

Route::get('/chat-room', 'ChatRoomController@index')->name('chat.index');
Route::post('/chat-room/store', 'ChatRoomController@store')->name('chat.store');
Route::post('/chat-room/reply/store', 'ChatRoomController@replyStore')->name('chat.store');
Route::post('/chat-room/load-user-message', 'ChatRoomController@loadUserMessage')->name('chat.load');
Route::get('/chat-room/load-user', 'ChatRoomController@loadUser')->name('chat.loaduser');
Route::get('/chat-room/load-user/{id}', 'ChatRoomController@loadUserById')->name('chat.loaduser.id');
Route::get('/chat-room/get-data', 'ChatRoomController@getChatData')->name('chat.getdata');
Route::get('/chat-room/delete-message/{id}', 'ChatRoomController@DeleteMessage')->name('chat.delete');



// down if needed
Route::get('/down', function () {
    Artisan::call('down');
});