<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/login', function () {
    return view('pages.login');
});

Route::get('/signup', function () {
    return view('pages.signup');
});

Route::get('/catcare', function () {
    return view('pages.catcare');
});

Route::get('/aboutus', function () {
    return view('pages.aboutus');
});

Route::get('/contact', function () {
    return view('pages.contact');
});
