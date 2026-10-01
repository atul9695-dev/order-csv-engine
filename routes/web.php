<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpdataController;

// ROOT REDIRECT TO DASHBOARD
Route::get('/', function () {
    return redirect()->route('orders.index');
});

// ORDERS DASHBOARD & CRUD
Route::get('/orders', [EmpdataController::class, 'index'])->name('orders.index');
Route::get('/orders/{id}', [EmpdataController::class, 'show'])->name('orders.show');
Route::get('/orders/{id}/edit', [EmpdataController::class, 'edit'])->name('orders.edit');
Route::put('/orders/{id}', [EmpdataController::class, 'update'])->name('orders.update');
Route::delete('/orders/{id}', [EmpdataController::class, 'destroy'])->name('orders.destroy');

// PHRASE 1: SINGLE ENTRY
Route::get('/phrase/create', [EmpdataController::class, 'create'])->name('phrase.create');
Route::post('/phrase/store', [EmpdataController::class, 'store'])->name('phrase.store');

// PHRASE 2: MULTIPLE DYNAMIC ENTRIES
Route::get('/phrase2/create', [EmpdataController::class, 'multipleCreate'])->name('phrase2.create');
Route::post('/phrase2/store', [EmpdataController::class, 'multiplestore'])->name('phrase2.store');

// Backward compatibility for typo URL
Route::get('/phras/create', [EmpdataController::class, 'multipleCreate']);
Route::post('/phras/store', [EmpdataController::class, 'multiplestore']);

// PHRASE 3: CSV BULK IMPORT & EXPORT
Route::get('/csv/create', [EmpdataController::class, 'csvCreate'])->name('csv.create');
Route::post('/csv/store', [EmpdataController::class, 'csvStore'])->name('csv.store');
Route::get('/csv/sample/download', [EmpdataController::class, 'downloadSample'])->name('csv.sample');
Route::get('/export-csv', [EmpdataController::class, 'exportCsv'])->name('orders.export');
