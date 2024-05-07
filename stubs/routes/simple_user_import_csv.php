<?php

use Illuminate\Support\Facades\Route;

Route::get('/simple-user-import-csv', [\App\Http\Controllers\SimpleUserImportCsvController::class, 'index'])->name('simple-user-import-csv.index');
Route::post('/simple-user-import-csv/upload', [\App\Http\Controllers\SimpleUserImportCsvController::class, 'import'])->name('simple-user-import-csv.import');