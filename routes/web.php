<?php

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

    $allimages = glob(base_path('public/img/logos/*.*'));

    $rndimages = array_rand($allimages, 10);

    foreach ($rndimages as $index) {
        $images[] = basename($allimages[$index]);
        $images[] = basename($allimages[$index]);
    }

    return view('welcome')->with(compact('images'));
});
