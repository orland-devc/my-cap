<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\TicketController;
use App\Models\TicketReply;
use App\Http\Controllers\OFficeTicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DataBankController;
use App\Models\Attachment;

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
    return view('landing');
});

// Route::resource('tickets', TicketController::class)->middleware(['auth', 'verified']);
// Route::resource('tickets', TicketController::class)->only(['index', 'create', 'store']);
// Route::resource('tickets', TicketController::class)
//     ->middleware(['auth', 'verified'])
//     ->names('tickets');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admindashboard', function () {
    return view('admindashboard');
})->middleware(['auth', 'verified'])->name('admindashboard');

Route::get('/officedashboard', function () {
    return view('officedashboard');
})->middleware(['auth', 'verified'])->name('officedashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// routes/web.php

Route::resource('tickets', TicketController::class)->middleware(['auth', 'verified']);

Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('ticket.show')->middleware(['auth', 'verified']);

Route::get('my-tickets', function () {
    return view('my-tickets');
})->middleware(['auth', 'verified'])->name('my-tickets');

// Route::put('tickets/{id}/unread', [TicketController::class, 'unread'])->name('tickets.unread');


Route::get('/chatbot', function () {
    return view('chatbot');
})->middleware(['auth', 'verified'])->name('chatbot');

// Route::get('/admindashboard', 'AdminController@dashboard')->name('admindashboard')->middleware('Administrator');
// Route::get('/dashboard', 'StudentController@dashboard')->name('dashboard')->middleware('Student');



Route::get( '/admin-add-ticket', function() {
    return view('profile.admin-add-ticket');
})->middleware(['auth','verified'])->name('admin-add-ticket');

Route::get('/MyTickets', [TicketController::class, 'userIndex'])->name('my-ticket');


Route::get('/tickets/{ticket}/assign', [TicketController::class, 'showAssignForm'])->name('tickets.assign');
Route::post('/tickets/{ticket}/assign', [TicketController::class, 'assignTicket'])->name('tickets.assign');

Route::get('/assigned-tickets', [TicketController::class, 'getAssignedTickets'])->name('assigned-tickets');

Route::resource('manage-chatbot', FaqController::class);

Route::post('/api/chatbot', [ChatbotController::class, 'handleMessage']);

Route::get( '/UserManagement', [TicketController::class, 'addUser'] )->middleware(['auth', 'verified'])->name('manage.users');

Route::resource('users', UserController::class)->middleware(['auth', 'verified']);


Route::get('users/create', function () {
    return view('add-user');
})->middleware(['auth', 'verified'])->name('add-user');

Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::post('/users/update', [UserController::class, 'update'])->name('users.update');

// Route::middleware(['auth', 'office'])->group(function () {
    Route::get('/assigned-tickets/{ticket}', [OfficeTicketController::class, 'show'])->name('office.tickets.show');
    // Add other routes for office users here
// });

// Route::middleware(['auth', 'office'])->group(function () {
    // Route::get('/my-tickets/{ticket}', [OfficeTicketController::class, 'showUserTicketDetails'])->name('user.tickets.show');
    // Add other routes for office users here
// });

Route::post('/tickets/{ticket}/reply', [OfficeTicketController::class, 'reply'])->name('office.tickets.reply');

// routes/web.php
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

Route::get('/analytics', [UserController::class, 'analytics'])->name('analytics');

Route::middleware(['auth'])->group(function () {

    Route::get('/office/tickets/{ticket}/updates', [TicketController::class, 'fetchUpdates'])->name('office.tickets.updates');
    Route::get('/office/tickets/{ticket}/replies', [TicketController::class, 'fetchReplies'])->name('office.tickets.replies');
    Route::post('/office/tickets/{ticket}/reply', [TicketController::class, 'submitReply'])->name('office.tickets.reply');

    Route::get('/my-tickets/{ticket}', [OfficeTicketController::class, 'showUserTicketDetails'])->name('user.tickets.show');

});




Route::get( '/ai.psu', [ChatbotController::class, 'chatbot'] );




Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('callback/google', [LoginController::class, 'handleGoogleCallback'])->name('callback.google');




//     Route::middleware(['auth'])->group(function () {
//         Route::get('/chat', [ChatController::class, 'index'])->name('chat');
//         Route::get('/messages', [ChatController::class, 'getMessages']);
//         Route::post('/messages', [ChatController::class, 'sendMessage']);
//     });



// Route::middleware(['auth'])->group(function () {
//     Route::get('/chat', [ChatController::class, 'getContacts'])->name('chat');
//     Route::get('/chat/{userId}', [ChatController::class, 'showConversation'])->name('chat.conversation');
//     Route::get('/chat/{userId}/messages', [ChatController::class, 'getMessages']);
//     Route::post('/chat/{userId}/messages', [ChatController::class, 'sendMessage']);
//     Route::post('/chat/{userId}/read', [ChatController::class, 'markAsRead']);
//     Route::get('/chat/contacts', [ChatController::class, 'getContacts']);
// });

// Route::middleware('auth')->group(function () {
//     Route::get('/chat', [ChatController::class, 'getUsersWithChats']);
//     Route::get('/chat/messages/{userId}', [ChatController::class, 'getMessages']);
//     Route::post('/chat/messages', [ChatController::class, 'sendMessage']);
// });



Route::middleware(['auth'])->group(function () {
    // Route::get('/chats/list', [ChatController::class, 'getChatList'])->name('chats.list');
    // Route::get('/messages/{id}', [MessagesController::class, 'show'])->name('messages.show');
    // Route::post('/messages/{id}', [MessagesController::class, 'store'])->name('messages.store');


    Route::get('/messages', [MessagesController::class, 'index'])->name('messages.index');


    Route::get('/chats/{chatId}/messages', [MessagesController::class, 'getMessages'])->name('chats.messages');
    Route::post('/chats/message', [MessagesController::class, 'sendMessage'])->name('chats.sendMessage');
    Route::get('/latest-chats', [MessagesController::class, 'getLatestChats']);
    Route::get('/search-users', [MessagesController::class, 'searchUsers']);
    Route::post('/chats/get-or-create/{userId}', [MessagesController::class, 'getOrCreateChat']);
    Route::post('/chats/start-new-chat', [MessagesController::class, 'startNewChat']);

});

// Route::get('/newChatBot', function () {
//     return view('newChatBot');
// });

Route::get('/newChatBot', [ChatController::class, 'index']);

Route::post('/chatbot10', [ChatbotController::class, 'processMessage']);

Route::get('uploads/{filename}', function ($filename) {
    $path = public_path('uploads/' . $filename);
    if (!Attachment::exists($path)) {
        abort(404);
    }
    return response()->file($path);
})->where('filename', '.*');


// Route::get('/chats/list', [MessagesController::class, 'getChatList'])->name('chats.list');



Route::get('/account', function () {
    return view('profile.profile-page');
});






Route::get( '/chatbot2', [ChatbotController::class, 'chatbot'] );

Route::get('data_bank', [DataBankController::class, 'create'])->name('data_bank.create');
Route::post('data_bank/store', [DataBankController::class, 'store'])->name('data_bank.store');

Route::post('data_bank/databank-update/{id}', [DataBankController::class, 'dataBankUpdate'])->name('dashboard.update');

Route::post('chatbot/update-info', [DataBankController::class, 'infoUpdate'])->name('dashboard.updateAll');

Route::post('data_bank/name-update', [DataBankController::class, 'nameUpdate'])->name('dashboard.nameupdate');
Route::post('data_bank/greet-update', [DataBankController::class, 'greetUpdate'])->name('dashboard.greetupdate');
Route::post('data_bank/fallback-update', [DataBankController::class, 'fallbackUpdate'])->name('dashboard.fallbackupdate');
Route::post('data_bank/repeated-update', [DataBankController::class, 'repeatedUpdate'])->name('dashboard.repeatupdate');

Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
Route::post('/tickets/{id}/reply', [TicketController::class, 'reply'])->name('tickets.reply');







require __DIR__.'/auth.php';
