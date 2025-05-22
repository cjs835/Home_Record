<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::group(['middleware'=>[
    'auth:sanctum',
    'verified'
]], function(){

    Route::get("/dashboard", function(){
        return view('admin.records');
    })->name('dashboard');

    Route::get("/records", function(){
        return view('admin.records');
    })->name('records');

    Route::name('records.')->group(function () {

        Route::get("/recordsm", function(){
            return view('admin.records-m');
        })->name('m');

        Route::get("/recordsh", function(){
            return view('admin.records-h');
        })->name('h');

        Route::get("/recordsd", function(){
            return view('admin.records-d');
        })->name('d');

        Route::get("/recordsw", function(){
            return view('admin.records-w');
        })->name('w');

        Route::get("/recordsmm", function(){
            return view('admin.records-m-m');
        })->name('mm');

        Route::get("/recordshm", function(){
            return view('admin.records-h-m');
        })->name('hm');

        Route::get("/recordsy", function(){
            return view('admin.records-y');
        })->name('y');

    });

    Route::get("/status", function(){
        return view('admin.records-status');
    })->name('status');
});
