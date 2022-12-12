<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Customers_Report;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;
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

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();
//Auth::routes(['register'=>false]);
Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles',RoleController::class);

    Route::resource('users',UserController::class);

});
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('invoices',InvoicesController::class);

Route::get('invoices_paid',[InvoicesController::class,'invoices_paid']);
Route::get('invoices_unpaid',[InvoicesController::class,'invoices_unpaid']);
Route::get('invoices_partial',[InvoicesController::class,'invoices_partial']);
Route::get('/Print_invoice/{id}', [InvoicesController::class,'Print_invoice']);
Route::resource('invoices_archive', InvoiceArchiveController::class);

Route::get('/edit_invoice/{id}', [InvoicesController::class,'edit']);
Route::get('/section/{id}', [InvoicesController::class,'getproducts']);
Route::get('/invoicedetails/{id}', [InvoicesDetailsController::class,'edit']);
Route::get('download/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'get_file']);

Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class,'open_file']);

Route::post('delete_file', [InvoicesDetailsController::class,'destroy'])->name('delete_file');
Route::get('/invoiceshow/{id}', [InvoicesController::class,'show'])->name('Status_show');
Route::post('/Status_Update/{id}', [InvoicesController::class,'Status_Update'])->name('Status_Update');
Route::resource('sections',SectionsController::class);
Route::resource('products',ProductsController::class);
Route::resource('InvoiceAttachments', InvoiceAttachmentsController::class);
Route::get('/InvoicesDetails/{id}', [InvoicesDetailsController::class,'edit']);
Route::get('invoices_report', [Invoices_Report::class,'index']);
Route::post('Search_invoices', [Invoices_Report::class,'Search_invoices']);
Route::get('customers_report', [Customers_Report::class,'index'])->name("customers_report");
Route::post('Search_customers', [Customers_Report::class,'Search_customers']);

Route::get('/{page}', [AdminController::class,'index']);

