<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('inventaris', InventarisController::class) ->parameters(['inventaris' => 'inventaris']);;
