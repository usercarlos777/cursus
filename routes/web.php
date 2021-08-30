<?php

use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\LicenseController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ChatGroupController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Instructor\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\Student\CartController;
use App\Http\Controllers\Student\CourseRatingController;
use App\Http\Controllers\Student\IndexController;
use App\Http\Controllers\Student\InstructorDiscussionController;
use App\Http\Controllers\Student\LikeDislikeCourseController;
use App\Http\Controllers\Student\ReportAbuseController;
use App\Http\Controllers\Student\SavedCoursesController;
use App\Http\Controllers\Student\SubscriptionController;
use App\Models\Instructor;
use App\Models\Student;
use Illuminate\Http\Request;
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

Route::post('saveEnvData', [LicenseController::class, 'saveEnvData']);
Route::any('installer', [LicenseController::class, 'installer']);
Route::post('saveAdminData', [LicenseController::class, 'saveAdminData']);
Route::post('activeLicence', [LicenseController::class, 'activeLicence']);
Route::get('activeLicence', [LicenseController::class, 'activeLicenceGet']);
Route::get('locale/{locale}', function ($locale) {
    \Session::put('locale', $locale);
    return redirect()->back();
})->name('locale.change');
Route::get('/home', function () {
    return redirect('admin/dashboard');
})->name('home');

Route::get('category/{id}', [CategoryController::class, 'getCategory']);


Route::get('/', [IndexController::class, 'index']);
Route::get('legal/{slug}', [AdminSettingController::class, 'websiteIndex']);
Route::any('instructors', [IndexController::class, 'instructorAll'])->name('instructorAll');
Route::get('instructors/{slug}/{id}', [IndexController::class, 'instructorShow'])->name('instructorShow');
Route::get('live', [IndexController::class, 'liveStreams'])->name('live.index');
Route::get('live/{slug}/{id}', [IndexController::class, 'liveStreamShow'])->name('live.show');
Route::any('explore', [IndexController::class, 'explore'])->name('explore');
Route::any('courses/{type?}', [IndexController::class, 'coursesAll'])->name('coursesAll');
Route::any('categories/{slug}/{id}', [IndexController::class, 'categoriesCourses'])->name('categoriesCourses');
Route::get('courses/{slug}/{id}', [IndexController::class, 'courseShow'])->name('courseShow');
Route::get('courses/{slug}/{id}/share', [IndexController::class, 'courseShare'])->name('courseShare');

Route::get('register', [AuthController::class, 'registerView']);
Route::get('/reset/{token}/{user_type}', [ResetPasswordController::class, 'showResetForm'])->name('student.showResetForm');
Route::get('/resetemail/{user_type}', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('student.showResetEmailForm');
Route::post('/reset', [ResetPasswordController::class, 'reset'])->name('student.password.update');

Route::get('success', function (Request $request) {
    $s = $request->get('session_id');
    return redirect("order/stripe/$s");
});

Route::any('help', [FAQController::class, 'faqHelp']);
Route::any('filter', [IndexController::class, 'filter']);
Route::get('login', [AuthController::class, 'LoginView']);

Route::post('register', [AuthController::class, 'studentRegister']);
Route::post('login', [AuthController::class, 'studentLogin']);
Route::get('cart/{id}/{from?}/add', [CartController::class, 'store'])->name('addtocart');
Route::get('instructor-comment/{id}/{action}', [InstructorDiscussionController::class, 'storeLikeDislike'])->name('ins.dis.social');
Route::get('stream/{id}/{action}', [LikeDislikeCourseController::class, 'streamLikeDislike'])->name('stream.likedislike');
Route::get('streamshare/{slug}/{id}', [IndexController::class, 'streamShare'])->name('stream.share');
Route::post('stream/comment', [LikeDislikeCourseController::class, 'streamComment'])->name('stream.comment');
Route::post('stream/comment/ajax', [LikeDislikeCourseController::class, 'streamCommentajax'])->name('stream.comment.ajax');
Route::delete('instructor-comment/{id}', [InstructorDiscussionController::class, 'destroy'])->name('ins.dis.destroy');
Route::get('report/{id}/add', [ReportAbuseController::class, 'store'])->name('addtoreport');
Route::get('report', [ReportAbuseController::class, 'index']);
Route::get('cart/{id}/remove', [CartController::class, 'destroy'])->name('removefromcart');
Route::get('save/{id}/add', [SavedCoursesController::class, 'store'])->name('addtosave');
Route::get('save/{id}/remove', [SavedCoursesController::class, 'destroy'])->name('removefromsave');
Route::get('subscription/{id}/add', [SubscriptionController::class, 'store'])->name('subscribe');
Route::get('like/{id}/{what}', [LikeDislikeCourseController::class, 'store'])->name('likedislike');
Route::get('like-delete/{id}', [LikeDislikeCourseController::class, 'destroy'])->name('deletelikedislike');
Route::get('subscription/{id}/remove', [SubscriptionController::class, 'destroy'])->name('unsubscribe');
Route::get('feedback', [FeedbackController::class, 'index']);
Route::post('feedback', [FeedbackController::class, 'store']);
Route::get('{user_type?}/auth/{provider}/redirect', [SocialController::class, 'redirectToProvider']);
Route::get('auth/{provider}/callback', [SocialController::class, 'handleProviderCallback']);
Route::post('savedevicetoken', function (Request $request) {
    if (Auth::guard('student')->check()) {
        Student::findOrFail(Auth::guard('student')->id())->update(['device_token' => $request->device_token]);
        return "student-done";
    } elseif (Auth::guard('instructor')->check()) {
        Instructor::findOrFail(Auth::guard('instructor')->id())->update(['device_token' => $request->device_token]);
        return "instructor-done";
    }
    return "nologin";
});
Route::group(['middleware' => ['auth:student', 'verified:stuverification.notice']], function () {

    Route::get('messages', [ChatGroupController::class, 'index'])->name('stu-messages');

    Route::get('notifications', [FAQController::class, 'notification']);
    Route::get('messages/{id}', [ChatGroupController::class, 'show'])->name('stu-message.show');
    Route::post('messages/send', [ChatGroupController::class, 'savemsg'])->name('stu-message.send');
    Route::post('messages/ajax', [ChatGroupController::class, 'latestmsgajax'])->name('message.ajax');

    Route::get('saved-course', [SavedCoursesController::class, 'index'])->name('saved-course');

    Route::get('subscription', [SubscriptionController::class, 'index'])->name('subscription');
    Route::get('cart', [CartController::class, 'index'])->name('cart');
    Route::post('ratting', [CourseRatingController::class, 'store']);
    Route::post('instructor-comment', [InstructorDiscussionController::class, 'store']);
    Route::get('order/{payment}/{token}', [OrderController::class, 'store'])->name('order.store');
    Route::get('order', [OrderController::class, 'index'])->name('order.index');
    Route::get('order-invoice/{id}', [OrderController::class, 'invoice'])->name('order.invoice');

    Route::get('saved-course/remove', [SavedCoursesController::class, 'removeAll'])->name('saved-course-delete');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.editstu');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.updatestu');
    Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.passwordstu');

    Route::get('thank-you', function () {
        return view('frontend.student.thankyou');
    });
});
Route::get('logout', function () {
    Auth::guard('student')->logout();
    return redirect('/');
})->name('stu.logout');
Route::get('/email/verify', function () {

    if (Auth::user()->hasVerifiedEmail()) {
        return redirect('home');
    }
    return view('auth.verify');
})->middleware('auth:student')->name('stuverification.notice');

Route::post('/email/verify/resend', function () {

    Auth::user()->sendEmailVerificationNotification();

    return back()->withResent(__('A fresh verification link has been sent to your email address..'));
})->middleware(['auth:student', 'web'])->name('stuverification.resend');
Route::get('email/verify/{id}/{hash}/{user_type}', [VerificationController::class, 'verify'])->name('ownverification.verify');
