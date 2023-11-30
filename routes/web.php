<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->middleware(['verify.shopify'])->name('home');

//1. You need to create a route named ‘shop’ in the shopify admin where you have to show your shop name and shop ID with a good design.
Route::get('/shop', function () {
    return view('shopinfo');
})->middleware(['verify.shopify'])->name('shopinfo');

//2. Also create a route named ‘collections’ in the shopify admin. This route will lists all available collections as follows:
    Route::get('/collections', [\App\Http\Controllers\CollectionController::class, 'collectionIndex'])
    ->middleware(['verify.shopify'])
    ->name('collection.index');

//Also, there will be a ‘create collection’ button for adding a new collection . After saving the form It will redirect to the collections route. 
//and editing an existing collection using a form having two fields (name & description). After saving the form It will redirect to the collections route. 
Route::post('/collections', [\App\Http\Controllers\CollectionController::class, 'collectionSave'])
    ->middleware(['verify.shopify'])
    ->name('collection.save');


// Create an option to show all products with the associated collection using the Products button as follows:
// name
// description
Route::get('/product/{collectionid}', [\App\Http\Controllers\ProductController::class, 'products'])
    ->middleware(['verify.shopify'])
    ->name('collection.products');

    Route::post('/product/{collectionid}', [\App\Http\Controllers\ProductController::class, 'products'])
    ->middleware(['verify.shopify'])
    ->name('collection.product.save');


Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])
    ->middleware(['verify.shopify'])->name('product.index');

Route::get('/groups', [\App\Http\Controllers\FaqController::class, 'groupIndex'])
    ->middleware(['verify.shopify'])
    ->name('group.index');

Route::post('/groups', [\App\Http\Controllers\FaqController::class, 'groupStore'])
    ->middleware(['verify.shopify'])
    ->name('group.save');



Route::get('/faqs/{groupid}', [\App\Http\Controllers\FaqController::class, 'faqs'])
    ->middleware(['verify.shopify'])
    ->name('group.faqs');
Route::post('/faqs/{groupid}', [\App\Http\Controllers\FaqController::class, 'faqs'])
    ->middleware(['verify.shopify'])
    ->name('group.faqs.save');



