<?php

use App\Http\Controllers\MediaLibraryController;
use App\Http\Controllers\UploaderController;
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

//Media library routes
Route::get('/', [MediaLibraryController::class, 'mediaLibrary'])->name('media-library');

//FILE UPLOADS CONTROLER
Route::post('medialibrary/upload', [UploaderController::class, 'upload'])->name('file-upload');
Route::post('medialibrary/delete', [UploaderController::class, 'delete'])->name('file-delete');
