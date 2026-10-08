<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |----------------------------------------------------------------------
    | Admin panel (web only). Protected by the `admin` middleware so only
    | users with user_role=admin can enter. The mobile app uses the
    | sanctum API and is completely unaffected by anything here.
    |----------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        /* ---- Coaching & Academy (existing) ---- */
        Route::resource('coaching-sessions', Admin\CoachingSessionController::class);
        Route::resource('academic-subjects', Admin\AcademicSubjectController::class);
        Route::resource('badges', Admin\BadgeController::class);

        Route::get('academic-plannings', [Admin\AcademicPlanningController::class, 'index'])->name('academic-plannings.index');
        Route::post('academic-plannings/{id}/toggle-trophy', [Admin\AcademicPlanningController::class, 'toggleTrophy'])->name('academic-plannings.toggle-trophy');

        /* ---- Store ---- */
        Route::resource('product-categories', Admin\ProductCategoryController::class)->except('show');
        Route::resource('products', Admin\ProductController::class);
        Route::get('orders', [Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
        Route::put('orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');

        /* ---- Catalog ---- */
        Route::resource('skill-types', Admin\SkillTypeController::class)->except('show');
        Route::resource('consultation-categories', Admin\ConsultationCategoryController::class)->except('show');

        /* ---- Reference / Lookup data ---- */
        Route::resource('countries', Admin\CountryController::class)->except('show');
        Route::resource('qualifications', Admin\QualificationController::class)->except('show');
        Route::resource('work-styles', Admin\WorkStyleController::class)->except('show');
        Route::resource('employment-statuses', Admin\EmploymentStatusController::class)->except('show');
        Route::resource('categories', Admin\CategoryController::class)->except('show');
        Route::resource('sub-categories', Admin\SubCategoryController::class)->except('show');

        /* ---- Content moderation (view / status / delete) ---- */
        Route::get('feed-posts', [Admin\FeedPostController::class, 'index'])->name('feed-posts.index');
        Route::get('feed-posts/{feedPost}', [Admin\FeedPostController::class, 'show'])->name('feed-posts.show');
        Route::post('feed-posts/{feedPost}/toggle-publish', [Admin\FeedPostController::class, 'togglePublish'])->name('feed-posts.toggle-publish');
        Route::delete('feed-posts/{feedPost}', [Admin\FeedPostController::class, 'destroy'])->name('feed-posts.destroy');

        Route::get('consultations', [Admin\ConsultationController::class, 'index'])->name('consultations.index');
        Route::get('consultations/{consultation}', [Admin\ConsultationController::class, 'show'])->name('consultations.show');
        Route::post('consultations/{consultation}/toggle-status', [Admin\ConsultationController::class, 'toggleStatus'])->name('consultations.toggle-status');
        Route::delete('consultations/{consultation}', [Admin\ConsultationController::class, 'destroy'])->name('consultations.destroy');

        Route::get('ideas', [Admin\IdeaController::class, 'index'])->name('ideas.index');
        Route::get('ideas/{idea}', [Admin\IdeaController::class, 'show'])->name('ideas.show');
        Route::post('ideas/{idea}/toggle-publish', [Admin\IdeaController::class, 'togglePublish'])->name('ideas.toggle-publish');
        Route::post('ideas/{idea}/toggle-featured', [Admin\IdeaController::class, 'toggleFeatured'])->name('ideas.toggle-featured');
        Route::delete('ideas/{idea}', [Admin\IdeaController::class, 'destroy'])->name('ideas.destroy');

        Route::get('reports', [Admin\ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/{report}', [Admin\ReportController::class, 'show'])->name('reports.show');
        Route::delete('reports/{report}', [Admin\ReportController::class, 'destroy'])->name('reports.destroy');

        Route::get('bookings', [Admin\BookingController::class, 'index'])->name('bookings.index');
        Route::get('bookings/{booking}', [Admin\BookingController::class, 'show'])->name('bookings.show');
        Route::put('bookings/{booking}/status', [Admin\BookingController::class, 'updateStatus'])->name('bookings.update-status');

        Route::get('skills', [Admin\SkillController::class, 'index'])->name('skills.index');
        Route::delete('skills/{skill}', [Admin\SkillController::class, 'destroy'])->name('skills.destroy');

        Route::get('goals', [Admin\GoalController::class, 'index'])->name('goals.index');
        Route::delete('goals/{goal}', [Admin\GoalController::class, 'destroy'])->name('goals.destroy');

        /* ---- User management ---- */
        Route::get('users', [Admin\UserManagementController::class, 'index'])->name('users.index');
        Route::get('users/{id}', [Admin\UserManagementController::class, 'show'])->name('users.show');
        Route::post('users/{id}/toggle-session-permission', [Admin\UserManagementController::class, 'toggleSessionPermission'])->name('users.toggle-session-permission');
        Route::post('users/{id}/toggle-active', [Admin\UserManagementController::class, 'toggleActive'])->name('users.toggle-active');
        Route::post('users/{id}/toggle-role', [Admin\UserManagementController::class, 'toggleRole'])->name('users.toggle-role');
    });
});

require __DIR__.'/auth.php';
