<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FindSitterController extends Controller
{
    public function index() {
        return view('Pages.dashboard_user.findsitter');
    }
}
