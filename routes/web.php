<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\CustomerController;



Route::get('/', function () {
    return redirect('home');
});

Route::get('/companies', function () {
    
    return view('company-master');
});

Auth::routes([

    'register' => false, // Register Routes...
  
    'reset' => false, // Reset Password Routes...
  
    'verify' => false, // Email Verification Routes...
  
  ]);
  
  Route::get('/logout',  [App\Http\Controllers\Auth\LoginController::class, 'logout']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/company', [App\Http\Controllers\HomeController::class, 'company'])->name('company');  
Route::get('/user', [App\Http\Controllers\HomeController::class, 'user'])->name('user');   
Route::get('/role', [App\Http\Controllers\HomeController::class, 'role'])->name('role');  
Route::get('/products', [App\Http\Controllers\HomeController::class, 'products'])->name('products');  
Route::get('/industry', [App\Http\Controllers\HomeController::class, 'industry'])->name('industry'); 
Route::get('/customertype', [App\Http\Controllers\HomeController::class, 'customertype'])->name('customertype');  


Route::get('/master/customers', [App\Http\Controllers\Master\CustomerController::class, 'index'])->name('customers'); 
Route::get('master/customers/add-address/{id}', [CustomerController::class, 'AddAddress'])->name('customers.AddAddress');
Route::post('master/customers/save-address', [CustomerController::class, 'saveAddress'])->name('customers.saveAddress');
Route::get('master/customers/edit-customer/{id}', [CustomerController::class, 'editCustomer'])->name('customers.editCustomer');
Route::post('master/customers/save-customer', [CustomerController::class, 'saveCustomer'])->name('customers.saveCustomer');
Route::get('master/customers/edit-address/{id}', [CustomerController::class, 'editAddress'])->name('customers.editAddress');
Route::post('master/customers/save-address', [CustomerController::class, 'saveAddress'])->name('customers.saveAddress');
Route::get('master/customers/add', [CustomerController::class, 'add'])->name('customers.add');
Route::post('master/customers/store', [CustomerController::class, 'store'])->name('customers.store');
Route::get('master/customers/fetch-address-types', [CustomerController::class, 'fetchAddressTypes'])->name('customers.fetchAddressTypes');


Route::get('/transactions/onsiteentry', [App\Http\Controllers\Transactions\OnsiteEntryController::class, 'index'])->name('onsiteentry'); 


//Route::get('transactions/trnenquiry', [Transactions\TrnEnquiryController::class, 'index']);  
//Route::get('transactions/trnenquiry/create', [Transactions\TrnEnquiryController::class, 'create']);  
//Route::post('transactions/trnenquiry/store', [Transactions\TrnEnquiryController::class, 'store']);  
//::get('transactions/trnenquiry/edit/{number?}', [Transactions\TrnEnquiryController::class, 'edit']);  

//Route::post('transactions/trnenquiry/update', [Transactions\TrnEnquiryController::class, 'update']);  
//Route::get('transactions/trnenquiry/delete/{number?}', [Transactions\TrnEnquiryController::class, 'delete']);  //