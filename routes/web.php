<?php

use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculateController;
use App\Http\Controllers\testController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\GoldPriceController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\SubscriptionController;

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

Route::get('/test', function () {
    return view('test', [
        'buyDate' => null,
        'goldPrice' => null,
        'downpayment_USD' => null
    ]);
});

// Route::view("/test", 'test');
Route::get('/test', [testController::class, 'index']);

Auth::routes(['verify' => true]);

Route::view('/', 'home')->name('home');
// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/calculator', [CalculateController::class, 'index']);
Route::post("/calculator", [CalculateController::class, 'output']);

// Route::get("/calculate/report", [CalculateController::class, 'calc']);
// Route::post("/report", [CalculateController::class, 'transaction_calc']);

//transaction
Route::get('/transaction', [TransactionController::class, 'getAll'])->middleware(['auth', 'verified']);
Route::post('/transaction/add', [TransactionController::class, 'add'])->middleware("auth");
Route::post('/transaction/update', [TransactionController::class, 'update'])->middleware("auth");
Route::post('/transaction/delete', [TransactionController::class, 'delete'])->middleware("auth");
Route::post('/transaction/report', [TransactionController::class, 'calculateHandler'])->middleware("auth");


Route::view('/goldprice', 'goldprice');
Route::get('/goldprice_qm', [APIController::class, 'getQMData']);

Route::get('/plan', [PlanController::class, 'getAll']);

Route::view("/email/verified", "auth.verified")->middleware(['auth', 'verified']);

Route::view('/blank', 'layouts.layout');

//portfolio
Route::get('/portfolio', [PortfolioController::class, 'getAll'])->middleware(['auth', 'verified']);
Route::post("/portfolio/getTransactions", [PortfolioController::class, 'getTransactions'])->middleware("auth");
Route::post('/portfolio/add', [PortfolioController::class, 'add'])->middleware("auth");
Route::post('/portfolio/update', [PortfolioController::class, 'update'])->middleware("auth");
Route::post('/portfolio/delete', [PortfolioController::class, 'delete'])->middleware("auth");
Route::post('/portfolio/delete/showtransactions', [PortfolioController::class, 'getOnlyTransactionsUnderPortfolioDelete'])->middleware("auth");
Route::post('/portfolio/edit/showtransactions', [PortfolioController::class, 'getOnlyTransactionsUnderPortfolioEdit'])->middleware("auth");
Route::post('/portfolio/report', [PortfolioController::class, 'calculateHandler'])->middleware("auth");


Route::get('set-locale/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'zh_CN', 'ms'])) {
        abort(404);
    }

    App::setLocale($locale);
    // Session
    session()->put('locale', $locale);

    return redirect()->back();
})->name('locale.setting');

Route::get('set-theme/{theme}', function ($theme) {
    if (!in_array($theme, ['dark', 'light'])) {
        abort(404);
    }
    // Session
    session()->put('theme', $theme);

    return redirect()->back();
})->name('theme.setting');

//admin
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm']);
Route::post('/admin/logout', [AdminLoginController::class, 'logout']);
Route::post('/admin/login', [AdminLoginController::class, 'login']);
// Route::get('/admin', function () {
//     if (Auth::check()) {
//         if (auth()->user()->is_admin) {
//             return view('admin.plan');
//         } else {
//             abort(401);
//         }
//     }
//     return redirect('/admin/login');
// });
Route::get('/admin', [PlanController::class, 'getAll'])->middleware("adminAuth");
Route::post('/admin', [PlanController::class, 'update'])->middleware("adminAuth");


Route::view("/chat", "chatBot");

//test
Route::get('/api/exchange', function(){
    return APIController::getExchange()['data'];
});
Route::get('/api/goldprice', function(){
    return APIController::getGoldPrice()['data'];
});
Route::get('/api/qmdata', function(){
    return APIController::getQMData()['data'];
});


Route::post('/plan', [SubscriptionController::class, "subscribePlan"])->middleware(['auth', 'verified']);
Route::post('/portfolio/checkLimit', [SubscriptionController::class, "transactionsPerPortfolioLimit_req"])->middleware("auth");