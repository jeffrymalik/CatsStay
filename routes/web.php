<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/signup', function () {
    return view('signUp');
});

Route::get('/catcare', function () {
    return view('catcare');
});

Route::get('/aboutus', function () {
    return view('aboutus');
});
