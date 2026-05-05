<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\GlobalDashboardController;
use App\Http\Controllers\Dashboard\VerticalDashboardController;
use App\Http\Controllers\Leads\LeadsController;
use App\Http\Controllers\VerticalSwitcherController;


// ─── Auth (guest only) ────────────────────────────────────────────────────────

Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class,    'create'])->name('auth.login');
    Route::post('/login',   [LoginController::class,    'store'])->name('auth.login.store');
    Route::get('/register', [RegisterController::class, 'create'])->name('auth.register');
    Route::post('/register',[RegisterController::class, 'store'])->name('auth.register.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('auth.logout');


// ─── Protected App ────────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {

    // ── Dashboards ────────────────────────────────────────────────────────────

    Route::get('/', GlobalDashboardController::class)->name('dashboard.global');
    Route::get('/dashboard', VerticalDashboardController::class)->name('dashboard.vertical');

    // ── Vertical Switcher ─────────────────────────────────────────────────────

    Route::post('/switch-vertical', VerticalSwitcherController::class)->name('vertical.switch');

    // ── Profile ───────────────────────────────────────────────────────────────

    Route::get('/profile',           [ProfileController::class, 'show'])          ->name('profile');
    Route::put('/profile',           [ProfileController::class, 'update'])        ->name('profile.update');
    Route::put('/profile/password',  [ProfileController::class, 'updatePassword'])->name('profile.password');

    // ── Leads ─────────────────────────────────────────────────────────────────

    Route::prefix('leads')->name('leads.')->group(function () {
        Route::get('/',        [LeadsController::class, 'index'])   ->name('index');
        Route::get('/create',  [LeadsController::class, 'create'])  ->name('create');
        Route::post('/',       [LeadsController::class, 'store'])   ->name('store');
        Route::get('/{id}',    [LeadsController::class, 'show'])    ->name('show');
        Route::put('/{id}',    [LeadsController::class, 'update'])  ->name('update');
        Route::delete('/{id}', [LeadsController::class, 'destroy']) ->name('destroy');
    });

});


// ─── UI Reference (no auth needed — template demo) ───────────────────────────

Route::prefix('ui')->name('ui.')->group(function () {
    Route::get('/', fn() => view('pages.dashboard.ecommerce', ['title' => 'UI Reference – Ecommerce']))->name('index');
    Route::get('/calendar', fn() => view('pages.calender', ['title' => 'UI Reference – Calendar']))->name('calendar');
    Route::get('/profile', fn() => view('pages.profile', ['title' => 'UI Reference – User Profile']))->name('profile');
    Route::get('/form-elements', fn() => view('pages.form.form-elements', ['title' => 'UI Reference – Form Elements']))->name('form-elements');
    Route::get('/basic-tables', fn() => view('pages.tables.basic-tables', ['title' => 'UI Reference – Basic Tables']))->name('basic-tables');
    Route::get('/blank', fn() => view('pages.blank', ['title' => 'UI Reference – Blank Page']))->name('blank');
    Route::get('/error-404', fn() => view('pages.errors.error-404', ['title' => 'UI Reference – 404 Error']))->name('error-404');
    Route::get('/line-chart', fn() => view('pages.chart.line-chart', ['title' => 'UI Reference – Line Chart']))->name('line-chart');
    Route::get('/bar-chart', fn() => view('pages.chart.bar-chart', ['title' => 'UI Reference – Bar Chart']))->name('bar-chart');
    Route::get('/signin', fn() => view('pages.auth.signin', ['title' => 'UI Reference – Sign In']))->name('signin');
    Route::get('/signup', fn() => view('pages.auth.signup', ['title' => 'UI Reference – Sign Up']))->name('signup');
    Route::get('/alerts', fn() => view('pages.ui-elements.alerts', ['title' => 'UI Reference – Alerts']))->name('alerts');
    Route::get('/avatars', fn() => view('pages.ui-elements.avatars', ['title' => 'UI Reference – Avatars']))->name('avatars');
    Route::get('/badge', fn() => view('pages.ui-elements.badges', ['title' => 'UI Reference – Badges']))->name('badges');
    Route::get('/buttons', fn() => view('pages.ui-elements.buttons', ['title' => 'UI Reference – Buttons']))->name('buttons');
    Route::get('/image', fn() => view('pages.ui-elements.images', ['title' => 'UI Reference – Images']))->name('images');
    Route::get('/videos', fn() => view('pages.ui-elements.videos', ['title' => 'UI Reference – Videos']))->name('videos');
});


// ─── Global Dashboard ─────────────────────────────────────────────────────────
// Vertical-agnostic. Shows all verticals summary. No session required.

Route::get('/', GlobalDashboardController::class)->name('dashboard.global');


// ─── Vertical Dashboard ───────────────────────────────────────────────────────
// Requires active_vertical in session. Shows that vertical's own KPIs.

Route::get('/dashboard', VerticalDashboardController::class)->name('dashboard.vertical');


// ─── Vertical Switcher ───────────────────────────────────────────────────────
// POST /switch-vertical  { vertical: 'atha-construction' }
// Sets session and redirects to /dashboard

Route::post('/switch-vertical', VerticalSwitcherController::class)
    ->name('vertical.switch');


// ─── Leads ───────────────────────────────────────────────────────────────────

Route::prefix('leads')->name('leads.')->group(function () {
    Route::get('/',        [LeadsController::class, 'index'])   ->name('index');
    Route::get('/create',  [LeadsController::class, 'create'])  ->name('create');
    Route::post('/',       [LeadsController::class, 'store'])   ->name('store');
    Route::get('/{id}',    [LeadsController::class, 'show'])    ->name('show');
    Route::put('/{id}',    [LeadsController::class, 'update'])  ->name('update');
    Route::delete('/{id}', [LeadsController::class, 'destroy']) ->name('destroy');
});


// ─── UI Reference (template demo — full sidebar) ─────────────────────────────

Route::prefix('ui')->name('ui.')->group(function () {

    Route::get('/', fn() => view('pages.dashboard.ecommerce', ['title' => 'UI Reference – Ecommerce']))->name('index');
    Route::get('/calendar', fn() => view('pages.calender', ['title' => 'UI Reference – Calendar']))->name('calendar');
    Route::get('/profile', fn() => view('pages.profile', ['title' => 'UI Reference – User Profile']))->name('profile');
    Route::get('/form-elements', fn() => view('pages.form.form-elements', ['title' => 'UI Reference – Form Elements']))->name('form-elements');
    Route::get('/basic-tables', fn() => view('pages.tables.basic-tables', ['title' => 'UI Reference – Basic Tables']))->name('basic-tables');
    Route::get('/blank', fn() => view('pages.blank', ['title' => 'UI Reference – Blank Page']))->name('blank');
    Route::get('/error-404', fn() => view('pages.errors.error-404', ['title' => 'UI Reference – 404 Error']))->name('error-404');
    Route::get('/line-chart', fn() => view('pages.chart.line-chart', ['title' => 'UI Reference – Line Chart']))->name('line-chart');
    Route::get('/bar-chart', fn() => view('pages.chart.bar-chart', ['title' => 'UI Reference – Bar Chart']))->name('bar-chart');
    Route::get('/signin', fn() => view('pages.auth.signin', ['title' => 'UI Reference – Sign In']))->name('signin');
    Route::get('/signup', fn() => view('pages.auth.signup', ['title' => 'UI Reference – Sign Up']))->name('signup');
    Route::get('/alerts', fn() => view('pages.ui-elements.alerts', ['title' => 'UI Reference – Alerts']))->name('alerts');
    Route::get('/avatars', fn() => view('pages.ui-elements.avatars', ['title' => 'UI Reference – Avatars']))->name('avatars');
    Route::get('/badge', fn() => view('pages.ui-elements.badges', ['title' => 'UI Reference – Badges']))->name('badges');
    Route::get('/buttons', fn() => view('pages.ui-elements.buttons', ['title' => 'UI Reference – Buttons']))->name('buttons');
    Route::get('/image', fn() => view('pages.ui-elements.images', ['title' => 'UI Reference – Images']))->name('images');
    Route::get('/videos', fn() => view('pages.ui-elements.videos', ['title' => 'UI Reference – Videos']))->name('videos');

});



// ─── Leads ───────────────────────────────────────────────────────────────────
// Active vertical is resolved from session — no slug in URL.

Route::prefix('leads')->name('leads.')->group(function () {
    Route::get('/',        [LeadsController::class, 'index'])   ->name('index');
    Route::get('/create',  [LeadsController::class, 'create'])  ->name('create');
    Route::post('/',       [LeadsController::class, 'store'])   ->name('store');
    Route::get('/{id}',    [LeadsController::class, 'show'])    ->name('show');
    Route::put('/{id}',    [LeadsController::class, 'update'])  ->name('update');
    Route::delete('/{id}', [LeadsController::class, 'destroy']) ->name('destroy');
});


// ─── UI Reference (template demo — full sidebar) ─────────────────────────────

Route::prefix('ui')->name('ui.')->group(function () {

    Route::get('/', function () {
        return view('pages.dashboard.ecommerce', ['title' => 'UI Reference – Ecommerce']);
    })->name('index');

    Route::get('/calendar', function () {
        return view('pages.calender', ['title' => 'UI Reference – Calendar']);
    })->name('calendar');

    Route::get('/profile', function () {
        return view('pages.profile', ['title' => 'UI Reference – User Profile']);
    })->name('profile');

    Route::get('/form-elements', function () {
        return view('pages.form.form-elements', ['title' => 'UI Reference – Form Elements']);
    })->name('form-elements');

    Route::get('/basic-tables', function () {
        return view('pages.tables.basic-tables', ['title' => 'UI Reference – Basic Tables']);
    })->name('basic-tables');

    Route::get('/blank', function () {
        return view('pages.blank', ['title' => 'UI Reference – Blank Page']);
    })->name('blank');

    Route::get('/error-404', function () {
        return view('pages.errors.error-404', ['title' => 'UI Reference – 404 Error']);
    })->name('error-404');

    Route::get('/line-chart', function () {
        return view('pages.chart.line-chart', ['title' => 'UI Reference – Line Chart']);
    })->name('line-chart');

    Route::get('/bar-chart', function () {
        return view('pages.chart.bar-chart', ['title' => 'UI Reference – Bar Chart']);
    })->name('bar-chart');

    Route::get('/signin', function () {
        return view('pages.auth.signin', ['title' => 'UI Reference – Sign In']);
    })->name('signin');

    Route::get('/signup', function () {
        return view('pages.auth.signup', ['title' => 'UI Reference – Sign Up']);
    })->name('signup');

    Route::get('/alerts', function () {
        return view('pages.ui-elements.alerts', ['title' => 'UI Reference – Alerts']);
    })->name('alerts');

    Route::get('/avatars', function () {
        return view('pages.ui-elements.avatars', ['title' => 'UI Reference – Avatars']);
    })->name('avatars');

    Route::get('/badge', function () {
        return view('pages.ui-elements.badges', ['title' => 'UI Reference – Badges']);
    })->name('badges');

    Route::get('/buttons', function () {
        return view('pages.ui-elements.buttons', ['title' => 'UI Reference – Buttons']);
    })->name('buttons');

    Route::get('/image', function () {
        return view('pages.ui-elements.images', ['title' => 'UI Reference – Images']);
    })->name('images');

    Route::get('/videos', function () {
        return view('pages.ui-elements.videos', ['title' => 'UI Reference – Videos']);
    })->name('videos');

});


// ─── Fallback ─────────────────────────────────────────────────────────────────
// Catches any unmatched URL and shows the 404 page.

Route::fallback(fn () => response()->view('errors.404', [], 404));
