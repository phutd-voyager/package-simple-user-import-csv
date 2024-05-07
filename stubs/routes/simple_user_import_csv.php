<?php

use Illuminate\Support\Facades\Route;

Route::get('/simple-user-import-csv', 'SimpleUserImportCsvController@index')->name('simple-user-import-csv.index');
Route::post('/simple-user-import-csv/upload', 'SimpleUserImportCsvController@upload')->name('simple-user-import-csv.upload');