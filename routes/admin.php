<?php 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PayoutController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\InstructorController;
use App\Http\Controllers\Admin\WebLanguageController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\NotiTemplateController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Instructor\InsVerifyController;

Route::get('/', function () {
    return redirect('admin/dashboard');
});

Route::group(['middleware' => ['auth', 'web']], function () {
    Route::get('/dashboard', [AdminSettingController::class, 'dashboard']);
    Route::resources([
        'role' => RoleController::class,
        'users' => UsersController::class,
        'languages' => LanguageController::class,
        'categories' => CategoryController::class,
        'sub-categories' => SubCategoryController::class,
        'instructors' => InstructorController::class,
        'students' => StudentController::class,
        'faqs' => FAQController::class,
        'payout' => PayoutController::class,
        'noti-template' => NotiTemplateController::class,
        'web-language' => WebLanguageController::class,
    ]);
    Route::get('download/{lang?}', [WebLanguageController::class, 'downloadBaseFile'])->name('download.langFile');
    Route::group(['prefix' => 'setting'], function () {
        Route::get('legal', [AdminSettingController::class, 'legal'])->name('setting.legal');
        Route::get('general', [AdminSettingController::class, 'general'])->name('setting.general');
        Route::get('mail', [AdminSettingController::class, 'email'])->name('setting.mail');
        Route::get('push-notification', [AdminSettingController::class, 'notiset'])->name('setting.pushnoti');
        Route::get('social', [AdminSettingController::class, 'social'])->name('setting.social');
        Route::get('social-login', [AdminSettingController::class, 'sociallogin'])->name('setting.social-login');
        Route::get('seo', [AdminSettingController::class, 'seo'])->name('setting.seo');
        Route::get('appearance', [AdminSettingController::class, 'appearance'])->name('setting.appearance');
        Route::get('payment', [AdminSettingController::class, 'payment'])->name('setting.payment');
        Route::get('other', [AdminSettingController::class, 'other'])->name('setting.other');
        Route::get('file-system', [AdminSettingController::class, 'fileSystem'])->name('setting.file-system');
        Route::post('update', [AdminSettingController::class, 'update'])->name('setting.update');
    });
    Route::group(['prefix' => 'report'], function () {
        Route::any('student-registration', [ReportController::class, 'studentReg'])->name('report.stureg');
        Route::any('instructor-registration', [ReportController::class, 'instructorReg'])->name('report.instructorreg');
        Route::any('subscription', [ReportController::class, 'subscription'])->name('report.subscription');
        Route::any('course-sell', [ReportController::class, 'courseSell'])->name('report.coursesell');
        Route::any('earning', [ReportController::class, 'earning'])->name('report.earning');
    });
    Route::get('verification', [InsVerifyController::class, 'index'])->name('verification.adindex');
    Route::get('feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::put('verification/{id}', [InsVerifyController::class, 'update'])->name('verification.update');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.adedit');
    Route::get('courses/{status}', [InstructorController::class, 'courseIndex']);
    Route::get('courses/{id}/show', [InstructorController::class, 'courseShow'])->name('admin-course.show');
    Route::get('review/{id}/delete', [InstructorController::class, 'reviewDelete'])->name('admin-review.delete');
    Route::post('courses/{id}/update', [InstructorController::class, 'courseUpdate'])->name('admin-course.update');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.adupdate');
    Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.adpassword');
    Route::get('logout', function () {
        Auth::logout();
        return redirect('login');
    })->name('admin.logout');
});
Auth::routes(['verify' => true]);
Route::get('/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('admin.showResetForm');
Route::get('/resetemail/{user_type}', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.showResetEmailForm');
Route::post('/reset', [ResetPasswordController::class, 'reset'])->name('admin.password.update');