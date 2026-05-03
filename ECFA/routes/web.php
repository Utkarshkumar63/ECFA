<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ECFAController;

Route::get('/', [ECFAController::class, 'index'])->name('home');
Route::get('/about', function () {
    return view('about-us');
});
Route::get('/events', [ECFAController::class, 'events'])->name('events');
Route::get('/achievements', [AdminController::class, 'achievements'])->name('achievements');
Route::get('/verify-cert/{cert_id}', [AdminController::class, 'verify'])->name('cert.verify');
Route::get('/gallery', [ECFAController::class, 'gallery'])->name('gallery');
Route::get('/news', [AdminController::class, 'news']);
Route::get('/contact', function () {
    return view('contact-us'); });
Route::get('/contact-submit', function () {
    return redirect()->route('contact'); });
Route::get('/verify-certificate', [AdminController::class, 'publicVerifyForm'])->name('public.verify.form');
Route::post('/verify-certificate', [AdminController::class, 'publicVerifyCheck'])->name('public.verify.check');
Route::post('/contact-submit', [ECFAController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/news', [AdminController::class, 'news'])->name('news.index');
Route::match(['get', 'post'], '/registration', [ECFAController::class, 'register'])->name('register');
Route::post('/registration', [ECFAController::class, 'register'])->name('register.submit');
Route::get('/player-login', function () {
    return view('player-login'); })->name('login');
Route::get('/admin-login', [ECFAController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/login-submit', [ECFAController::class, 'login'])->name('login.submit');
Route::post('/logout', [ECFAController::class, 'logout'])->name('logout');
Route::get('/admin-learn', [ECFAController::class, 'adminLearn'])->name('admin.learn');
Route::post('/admin/learn/upload', [ECFAController::class, 'storeLearn'])->name('admin.learn.upload');
Route::delete('/admin/learn/delete/{id}', [ECFAController::class, 'deleteLearn'])->name('admin.learn.delete');
Route::middleware(['auth'])->group(function () {
    Route::get('/learn', [ECFAController::class, 'playerLearn'])->name('player.learn');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'playerDashboard'])->name('player.dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('player.profile');
    Route::get('/profile/change-password', [UserController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/profile/change-password', [UserController::class, 'updatePassword'])->name('password.update');
    Route::get('/my-certificate/{id}', [UserController::class, 'viewCertificate'])->name('certificate.view');
    Route::get('/learn', [ECFAController::class, 'playerLearn'])->name('player.learn');
    Route::post('/events/join/{id}', [ECFAController::class, 'joinEvent'])->name('event.join');
    Route::get('/my-certificate/{id}', [AdminController::class, 'view'])
        ->name('certificate.view');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-dashboard', [ECFAController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/learn/view/{id}', [AdminController::class, 'viewMaterial'])->name('admin.learn.view');
    Route::post('/approve-player/{id}', [ECFAController::class, 'approvePlayer'])->name('admin.approve');
    Route::delete('/delete-player/{id}', [ECFAController::class, 'deletePlayer'])->name('admin.player.delete');
    Route::get('/admin-events', [ECFAController::class, 'adminEvents'])->name('admin.events');
    Route::get('/admin-gallery', [ECFAController::class, 'adminGallery'])->name('admin.gallery');
    Route::post('/admin/events/store', [ECFAController::class, 'storeEvent'])->name('admin.event.store');
    Route::delete('/admin/events/delete/{id}', [ECFAController::class, 'deleteEvent'])->name('admin.event.delete');
    Route::delete('/admin/gallery/delete/{id}', [ECFAController::class, 'deleteGallery'])
        ->name('admin.gallery.delete');
    Route::get('/admin/achievements/add', [UserController::class, 'addAchievementForm'])->name('admin.achievement.add');
    Route::post('/admin/achievements/store', [UserController::class, 'storeAchievement'])->name('admin.achievement.store');
    Route::post('/admin/events/status/{id}', [ECFAController::class, 'changeStatus'])
        ->name('admin.event.status');
    Route::get('/admin/events/edit/{id}', [ECFAController::class, 'editEvent'])
        ->name('admin.event.edit');
    Route::post('/admin/events/update/{id}', [ECFAController::class, 'updateEvent'])
        ->name('admin.event.update');
    Route::post('/admin/gallery/store', [ECFAController::class, 'storeGallery'])->name('admin.gallery.store');
    Route::get('/admin/events/{id}/participants', [ECFAController::class, 'viewEventParticipants'])->name('admin.event.participants');
    Route::post('/admin/event/{eventId}/participant/{userId}/approve', [ECFAController::class, 'approveEventParticipant'])->name('admin.event.participant.approve');
    Route::post('/admin/event/{eventId}/participant/{userId}/reject', [ECFAController::class, 'rejectEventParticipant'])->name('admin.event.participant.reject');
    Route::get('/admin/event/{id}/participants/pdf', [ECFAController::class, 'downloadParticipantsPDF'])->name('admin.event.participants.pdf');
    Route::get('/admin-players', [AdminController::class, 'adminPlayers'])->name('admin.players');
    Route::get('/admin/player/{id}', [AdminController::class, 'showPlayer'])->name('admin.player.show');
    Route::get('/admin/player/{id}/edit', [AdminController::class, 'editPlayer'])->name('admin.player.edit');
    Route::get('/admin/player/{id}/update', function($id) {return redirect()->route('admin.player.edit', $id);});
    Route::put('/admin/player/{id}/update', [AdminController::class, 'updatePlayer'])->name('admin.player.update');
    Route::post('/admin/player/{id}/approve', [ECFAController::class, 'approvePlayer'])->name('admin.player.approve');
    Route::delete('/admin/player/{id}/delete', [ECFAController::class, 'deletePlayer'])->name('admin.player.delete');
    Route::get('/admin-achievements', [AdminController::class, 'adminAchievements'])->name('admin.achievements');
    Route::post('/admin/achievement/store', [AdminController::class, 'storeAchievement'])->name('admin.achievement.store');
    Route::delete('/admin/achievement/{id}', [AdminController::class, 'deleteAchievement'])->name('admin.achievement.delete');
    Route::post('/admin/event/{event}/user/{user}/issue-cert', [AdminController::class, 'generate'])->name('admin.issue.cert');
    Route::post('/admin/event/{event_id}/issue-cert/{user_id}', [AdminController::class, 'generate'])->name('admin.issue.cert');
    Route::get('/admin/smart-issue', [AdminController::class, 'showSmartIssueForm'])->name('admin.issue.cert.smart');
    Route::post('/admin/smart-issue/store', [AdminController::class, 'storeCertificate'])->name('admin.issue.cert.store');
    Route::get('/admin/messages', [AdminController::class, 'adminMessages'])->name('admin.messages');
    Route::post('/admin/messages/reply/{id}', [AdminController::class, 'storeReply'])->name('admin.messages.reply');
    Route::get('/admin/news', [AdminController::class, 'adminNews'])->name('admin.news');
    Route::post('/admin/news/store', [AdminController::class, 'storeNews'])->name('admin.news.store');
    Route::get('/admin/news/edit/{id}', [AdminController::class, 'editNews'])->name('admin.news.edit');
    Route::post('/admin/news/update/{id}', [AdminController::class, 'updateNews'])->name('admin.news.update');
    Route::delete('/admin/news/delete/{id}', [AdminController::class, 'deleteNews'])->name('admin.news.delete');
    Route::get('/admin/events/{id}/attendance', [AdminController::class, 'showEventAttendance'])->name('admin.event.attendance');
    Route::post('/admin/events/{id}/attendance', [AdminController::class, 'storeEventAttendance'])->name('admin.event.attendance.store');
    Route::get('/admin/daily-attendance', [AdminController::class, 'dailyAttendance'])->name('admin.daily.attendance');
    Route::post('/admin/daily-attendance/save', [AdminController::class, 'saveDailyAttendance'])->name('admin.daily.attendance.save');
});
