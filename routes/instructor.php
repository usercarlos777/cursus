<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ChatGroupController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Instructor\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;


Route::get('/', function () {
    return redirect('instructor/home');
});

Route::get('/email/verify', function () {

    if (Auth::user()->hasVerifiedEmail()) {
        return redirect('home');
    }
    return view('auth.verify');
})->middleware('auth:instructor')->name('insverification.notice');

Route::post('/email/verify/resend', function () {

    Auth::user()->sendEmailVerificationNotification();

    return back()->withResent(__('A fresh verification link has been sent to your email address..'));
})->middleware(['auth:instructor', 'web'])->name('insverification.resend');
Route::get('email/verify/{id}/{hash}/{user_type}', [VerificationController::class, 'verify'])->name('ownverification.verify');

Route::get('register', [AuthController::class, 'registerView']);
Route::get('{user_type?}/auth/{provider}/redirect', [SocialController::class, 'redirectToProvider']);
Route::get('login', [AuthController::class, 'LoginView']);
Route::get('/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('instructor.showResetForm');
Route::get('/resetemail/{user_type}', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('instructor.showResetEmailForm');
Route::post('/reset', [ResetPasswordController::class, 'reset'])->name('instructor.password.update');
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => ['auth:instructor', 'verified:insverification.notice']], function () {
    Route::resources([
        'courses' => CourseController::class,
        'course-content' => CourseContentController::class,
        'special-discount' => SpecialDiscountController::class,
        'lectures' => LectureController::class,
        'live-stream' => LiveStreamController::class,
    ]);

    Route::get('messages/{id}', [ChatGroupController::class, 'show'])->name('ins-message.show');
    Route::post('messages/send', [ChatGroupController::class, 'savemsg'])->name('ins-message.send');
    Route::post('messages/ajax', [ChatGroupController::class, 'latestmsgajax'])->name('ins-message.ajax');
    Route::get('messages', [ChatGroupController::class, 'index'])->name('ins-messages');

    Route::get('home', [InsVerifyController::class, 'dashboard'])->name('ins-home');
    Route::get('analytics', [InsVerifyController::class, 'analytics'])->name('ins-analytics');
    Route::any('help', [FAQController::class, 'faqHelp']);
    Route::get('notifications', [FAQController::class, 'notification'])->name('ins-notification');

    Route::get('live-stream-end', [LiveStreamController::class, 'streamEnd'])->name('live-stream.end');
    Route::post('courses-update-media', [CourseController::class, 'updateMedia'])->name('courses.mediaUpdate');
    Route::get('courses/{id}/update-status/{status}', [CourseController::class, 'updateStatus'])->name('courses.updateStatus');
    Route::post('courses-update-full/{course}', [CourseController::class, 'fullUpdate'])->name('courses.fullUpdate');
    Route::post('courses-update-session', [CourseController::class, 'updateSession'])->name('courses.sessionUpdate');
    Route::post('course-content-store', [CourseContentController::class, 'storeOnlyContent'])->name('course-content.store-only');
    Route::get('course-content-move/{courseContent}/{moved}', [CourseContentController::class, 'upSideDown'])->name('course-content.move');
    Route::get('review', [CourseController::class, 'allReview'])->name('review.index');
    Route::get('lectures/{lecture}/{moved}', [LectureController::class, 'upSideDown'])->name('lectures.move');

    Route::get('feedback', [FeedbackController::class, 'index']);
    Route::any('earning', [BusinessController::class, 'earning']);
    Route::any('statements', [BusinessController::class, 'statements']);
    Route::get('payout', [BusinessController::class, 'payout']);
    Route::post('payout', [BusinessController::class, 'payoutStore'])->name('payout.store');

    Route::get('order-invoice/{id}', [OrderController::class, 'invoice'])->name('order.invoice-ins');

    Route::post('feedback', [FeedbackController::class, 'store']);

    Route::get('verification', [InsVerifyController::class, 'index'])->name('verification.index');

    Route::post('verification', [InsVerifyController::class, 'store'])->name('verification.store');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'updateins'])->name('profile.updateins');
    Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.password');
});
Route::get('logout', function () {

    Auth::guard('instructor')->logout();
    return redirect('instructor/login');
})->name('ins.logout');
