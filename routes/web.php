<?php

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

Route::get('/access', [App\Http\Controllers\AccessControllController::class, 'index'])->name('access')->withoutMiddleware(App\Http\Middleware\AccessControll::class);
Route::post('/access', [App\Http\Controllers\AccessControllController::class, 'access'])->name('legitimate');

Route::middleware('access')->group(function() {
	Auth::routes();

	Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

	Route::middleware('auth')->group(function() {
		Route::get('/home', [App\Http\Controllers\UserController::class, 'index']);

		Route::get('/new', [App\Http\Controllers\IdeaController::class, 'create'])->name('idea.new');

		Route::get('idea/{idea}', [App\Http\Controllers\IdeaController::class, 'show'])->name('idea.show');

		Route::post('idea', [App\Http\Controllers\IdeaController::class, 'store'])->name('idea.store');

		Route::get('ideas', [App\Http\Controllers\IdeaController::class, 'list'])->name('ideas.list');

		Route::get('profile/{user}', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');

		Route::get('/leaderboard', [App\Http\Controllers\UserController::class, 'leaderboard'])->name('leaderboard');


		Route::patch('idea/{idea}/vote', [App\Http\Controllers\VoteController::class, 'vote'])->name('vote');


		Route::get('image/{image}/preview', [App\Http\Controllers\AttachmentController::class, 'preview'])->name('image.preview');

		Route::post('idea/{idea}/attachments', [App\Http\Controllers\AttachmentController::class, 'store'])->name('idea.attachments');

		Route::patch('idea/{idea}/attachments', [App\Http\Controllers\AttachmentController::class, 'update'])->name('attachment.update');

		Route::post('idea/{idea}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('idea.comments.store');

		Route::get('areas', [App\Http\Controllers\AreaController::class, 'index'])->name('areas');

		Route::get('area/{area}', [App\Http\Controllers\AreaController::class, 'show'])->name('area');

		Route::post('idea/{idea}/report', [App\Http\Controllers\IdeaController::class, 'report'])->name('idea.report');

		Route::delete('idea/{idea}/delete', [App\Http\Controllers\IdeaController::class, 'delete'])->name('idea.delete');
	});
});
